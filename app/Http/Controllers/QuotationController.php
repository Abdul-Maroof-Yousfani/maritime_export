<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Quotation_Data;
use App\Models\Demand;
use App\Helpers\CommonHelper;
use App\Helpers\NotificationHelper;
use App\Helpers\QuotationHelper;
use App\Helpers\ReuseableCode;
use App\Models\Attachement;
use App\Models\DemandData;
use App\Models\ReverseLog;
use Exception;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class QuotationController extends Controller
{
    protected $page = "";
    public function __construct(Request $request)
    {

        $this->middleware('auth');
        $this->page = 'Purchase.Quotation.' . $request->segment(2);
    }

    public function create_quotation(Request $request)
    {

        return view($this->page);
    }


    public function create_quotation_ajax(Request $request)
    {

        $from = $request->from;
        $to = $request->to;

        $data =   DB::Connection('mysql2')->table('demand')
            ->where('status', 1)
            ->whereBetween('demand_date', [$from, $to])
            ->where('demand_status', 2)
            ->where('quotation_skip', 0)
            ->where('quotation_approve', 0);


        return view($this->page, compact('data'));
    }

    public function quotation_no($month, $year, $location)
    {


        $str = Quotation::where('company_location_id', $location)->orderBy('id', 'desc')->count();

        $voucher_no = 'qo-' . CommonHelper::getCompanyLocationPrefix($location) . '-' . sprintf("%'05d", ($str + 1));// . date('my');
        // $quotation_no = '';
        // $variable = 100;
        // sprintf("%'03d", $variable);
        // $str = DB::Connection('mysql2')->selectOne("select max(convert(substr(`voucher_no`,7,length(substr(`voucher_no`,3))-3),signed integer)) reg
        // from `quotation` where substr(`voucher_no`,3,2) = " . $year . " and substr(`voucher_no`,5,2) = " . $month . "")->reg;
        // $str = $str + 1;
        // $str = sprintf("%'03d", $str);
        // return  $job_order_no = 'qo' . $year . $month . $str;
        return $voucher_no;
    }

    public function get_pr_for_quotaion($id)
    {
        $data = DB::Connection('mysql2')->table('demand as a')
            ->join('demand_data as b', 'a.id', '=', 'b.master_id')
            ->select('b.*')
            ->where('a.status', 1)
            ->where('a.id', $id);

        return $data;
    }
    public function quotation_form(Request $request)
    {

        $id = $request->id;
        $this->check_pr_status($id);

        if ($this->check_pr_status($id) > 0) :
            return redirect()->back()->with('error', 'Quotation Againts This PR Alreday Approved');
        endif;

        $voucher_no = $this->quotation_no(date('m'), date('y'), $request);
        $request_data = $this->get_pr_for_quotaion($request->id)->where('quotation_id', 0)->get();
        return view($this->page, compact('voucher_no', 'request_data', 'id'));
    }

    public  function get_pr_no($id)
    {

        return DB::Connection('mysql2')->table('demand')->where('id', $id)->value('demand_no');
    }


    public function check_pr_status($id)
    {
        return Quotation::where('pr_id', $id)->where('status', 1)->where('quotation_status', 2)->count();
    }
    public function insert_quotation(Request $request)
    {

        if ($this->check_pr_status($request->pr_id) > 0) :
            return redirect()->back()->with('error', 'Quotation Againts This PR Alreday Approved');
        endif;

        DB::Connection('mysql2')->beginTransaction();
        $voucher_no = $this->quotation_no(date('m'), date('y'),1);
        try {
            $quotation = new Quotation();
            $quotation = $quotation->SetConnection('mysql2');

            $demand = NotificationHelper::get_dept_id('demand', 'id', $request->pr_id)->select('sub_department_id', 'p_type')->first();


            $quotation->dept_id = $demand->sub_department_id;
            $quotation->p_type = $demand->p_type;
            $quotation->description = $request->description_1;

            $quotation->pr_id = $request->pr_id;
            $quotation->pr_no = $this->get_pr_no($request->pr_id);
            $quotation->voucher_no = $voucher_no;
            $quotation->voucher_date = $request->demand_date_1;
            $quotation->vendor_id = $request->supplier;
            $quotation->ref_no = $request->ref_no;
            $quotation->gst = $request->sales_taxx;
            $quotation->gst_amount = CommonHelper::check_str_replace($request->sales_amount_td);
            $quotation->date = date('Y-m-d');
            $quotation->status = 1;
            $quotation->username = Auth::user()->name;
            $quotation->save();
            $master_id = $quotation->id;

            $quotation_data = $request->pr_data_id;

            foreach ($quotation_data  as $key => $row) :
                $quotation_data = new Quotation_Data();
                $quotation_data = $quotation_data->SetConnection('mysql2');
                $quotation_data->master_id = $master_id;
                $quotation_data->voucher_no = $voucher_no;
                $quotation_data->pr_id = $request->pr_id;
                $quotation_data->pr_data_id = $row;
                $quotation_data->rate = $request->input('rate')[$key];
                $quotation_data->amount = $request->input('amount')[$key];
                $quotation_data->discount_percent = $request->input('discount_percent')[$key];
                $quotation_data->discount_amount = $request->input('discount_amount')[$key];
                $quotation_data->net_amount = $request->input('net_amount')[$key];
                $quotation_data->save();

            endforeach;

            $demand_no = DB::Connection('mysql2')->table('demand')->where('id', $request->pr_id)->value('demand_no');
            $subject = 'Purchase Quotation For ' . $demand_no;
            // NotificationHelper::send_email('Purchase Quotation', 'Create', $demand->sub_department_id, $voucher_no, $subject, $demand->p_type);

            DB::Connection('mysql2')->commit();
        } catch (Exception $ex) {
            DB::rollBack();
            // return self::index($request)->withErrors($ex->getMessage());
        }
        return redirect('quotation/quotation_list')->with('message', 'Quotation Successfully Saved');
    }

    public function update_quotation($id, Request $request)
    {
        // dd($request->all());
        DB::Connection('mysql2')->beginTransaction();

        try {
            $quotation = Quotation::find($id);
            $quotation->description = $request->description_1;
            $quotation->voucher_no = $request->pr_no;
            $quotation->group_number = $request->group_number;
            $quotation->voucher_date = $request->demand_date_1;
            $quotation->vendor_id = $request->supplier;
            $quotation->ref_no = $request->ref_no;
            $quotation->gst = $request->sales_taxx;
            $quotation->gst_amount = CommonHelper::check_str_replace($request->sales_amount_td);
            $quotation->date = date('Y-m-d');
            $quotation->status = 1;
            $quotation->username = Auth::user()->name;
            // dd($quotation);
            $quotation->update();

            $master_id = $id;
            $quotationAttachment = Quotation::find($master_id);
            
            $file = Input::file('file');
            if (isset($file)) {
                foreach ($file as $key => $value) {
                    $newfilename = date('dmYHis') . str_replace(" ", "", basename($value->getClientOriginalName()));
                    $value->move(public_path('uploads/attachement'), $newfilename);

                    $attachment =  new Attachement();
                    $attachment->image_src = 'public/uploads/attachement/' . $newfilename;
                    $attachment->status = 1;
                    $quotationAttachment->comments()->save($attachment);
                }
            }
            $quotation_data = $request->quotation_data_id;

            foreach ($quotation_data  as $key => $row) :
                $quotation_data = Quotation_Data::find($row);
                $quotation_data = $quotation_data->SetConnection('mysql2');
                $quotation_data->master_id = $master_id;
                $quotation_data->voucher_no = $request->pr_no;
                $quotation_data->pr_id = $request->pr_id[$key];
                $quotation_data->pr_data_id = $request->pr_data_id[$key];
                $quotation_data->sub_item_desc = $request->input('sub_item_desc')[$key];
                $quotation_data->rate = $request->input('rate')[$key];
                $quotation_data->amount = $request->input('amount')[$key];
                $quotation_data->discount_percent = $request->input('discount_percent')[$key];
                $quotation_data->discount_amount = $request->input('discount_amount')[$key];
                $quotation_data->net_amount = $request->input('net_amount')[$key];
                $quotation_data->update();
            endforeach;
            // $demand_no = DB::Connection('mysql2')->table('demand')->where('id', $request->pr_id)->value('demand_no');
            // $subject = 'Purchase Quotation For ' . $demand_no;
            // NotificationHelper::send_email('Purchase Quotation', 'Create', $demand->sub_department_id, $voucher_no, $subject, $demand->p_type);
            DB::Connection('mysql2')->commit();
        } catch (Exception $ex) {
            DB::rollBack();
            // return self::index($request)->withErrors($ex->getMessage());
        }
        return redirect('quotation/quotation_list')->with('message', 'Quotation Successfully Update');
    }

    public function quotation_list()
    {


        return view($this->page);
    }

    public function quotation_query($company_location_id = '',$status = '')
    {


        $company_locations = ReuseableCode::getUserWiseLocationRights();
        $data = DB::Connection('mysql2')->table('quotation as a')
            ->join('quotation_data as b', 'a.id', '=', 'b.master_id')
            // ->join('demand as c', 'a.pr_id', '=', 'c.id')
            ->select('a.*', DB::Connection('mysql2')->raw('SUM(b.net_amount) As net_amount')) //, 'c.demand_date', 'c.quotation_approve')
            ->where('a.status', 1)
            ->whereIn('a.company_location_id', $company_locations);
        if($status == 'pending'){
            $data = $data->whereNull('a.checked_username');
        }
        
        if($status == 'not_checked'){
            $data = $data->whereNull('a.checked_username');
        }
        if($status == 'checked'){
            $data = $data->whereNotNull('a.checked_username');
        }
        if($status == 'checked_but_not_audited'){
            $data = $data->whereNotNull('a.checked_username')->whereNull('a.audited_username');
        }
        if($status == 'audited'){
            $data = $data->whereNotNull('a.audited_username');
        }
        if($status == 'audited_but_not_approved'){
            $data = $data->whereNotNull('a.audited_username')->whereNull('a.approved_username');
        }
        if($status == 'approved'){
            $data = $data->whereNotNull('a.approved_username');
        }
        $data = $data->groupBy('a.id')
            ->orderBy('a.id', 'Desc')
            ->orderBy('a.pr_no');
            if(!empty($company_location_id))
            {
                $data->where('a.company_location_id', $company_location_id);
            }

           $data = $data->get();
           return  $data;
    }

    public function quotation_list_ajax()
    {
       $company_location_id =  $_GET['company_location_id'];
       $status =  $_GET['status'];

        $data = $this->quotation_query($company_location_id,$status);


        return view($this->page, compact('data'));
    }

    public function view_quotation(Request $request)
    {
        $id = $request->id;
        $quotation = Quotation::where('id', $id)->first();

        $quotation_data = DB::Connection('mysql2')->table('quotation_data as a')
            ->join('demand_data as b', 'a.pr_data_id', '=', 'b.id')
            ->where('a.master_id', $id)
            ->get();
        return view($this->page, compact('quotation', 'quotation_data', 'id'));
    }

    public function approve(Request $request)
    {
        if ($this->check_pr_status($request->pr_id) > 0) :
            echo 'no';
            die;
        endif;
        $quotation = Quotation::find($request->id);
        $quotation->quotation_status = 2;
        $quotation->approve_username = Auth::user()->name;
        $quotation->save();
        $pr_id = $quotation->pr_id;

        $demand = new Demand();
        $demand = $demand->SetConnection('mysql2');
        $demand = $demand->find($pr_id);
        $demand->quotation_approve = 1;
        $demand->save();


        $subject = 'Purchase Quotation Approved';

        // NotificationHelper::send_email('Purchase Quotation','Create',$sub_department_id,$voucher_no,$subject);
        echo $request->id;
    }


    public function qutation_summary(Request $request)
    {
        $groupNumber = $request->groupno;
        $pr_id = Quotation_Data::where('master_id',$request->quotation_id)->groupBy('pr_id')->pluck('pr_id')->toArray();
        $vendor = DB::Connection('mysql2')
            ->table('quotation as a')
            ->join('quotation_data as data','a.id','=','data.master_id')
            ->join('supplier as b','a.vendor_id','=','b.id')
            ->join('demand as c','c.id','=','data.pr_id')
            ->select('a.id','data.pr_id','b.name','a.vendor_id', 'data.vendor','c.id as demand_id','a.dept_id','c.demand_no','a.p_type','data.id as quotation_data_id','a.gst','c.sub_department_id','a.company_location_id', 'a.attachment')
            ->where('a.group_number',$groupNumber)
            // ->where('a.gst','!=',0)
            ->where('a.status',1)
            ->groupBy('a.vendor_id')
            ->get();
// dd($vendor);
       $company_location = $vendor[0]->company_location_id;

       $demand_data = DB::Connection('mysql2')->table('demand_data as a')
        ->join('demand as d','d.id','=','a.master_id')
        ->join('quotation_data as c','c.pr_data_id','=','a.id')
        ->join('quotation','c.master_id','=','quotation.id')
        ->join('subitem as b','a.sub_item_id','=','b.id')
        ->select('d.id as demand_id', 'b.sku_code', 'b.sub_ic','a.id','c.quotation_status','a.sub_item_id',
        'a.sub_ic_desc','c.rate','a.qty', 'c.qty as approve_qty','c.demand_qty','c.vendor','c.id as quotation_id',
        'quotation.id as quotation_master_id','a.master_id','c.description','a.demand_no','d.sub_department_id')
        ->where('quotation.status',1)
        //    ->where('quotation.gst','!=',0)
       ->where('quotation.group_number',$groupNumber)
       ->where('c.status',1)
       ->groupBy('a.id')
       ->get();

       $quotation = Quotation::where('group_number', $groupNumber)->where('status', 1)->first();



        return view($this->page, compact('vendor', 'demand_data','groupNumber','company_location', 'quotation'));
    }

    public function approved_quotation_summary(Request $request)
    {

        //dd($request->all());
        DB::Connection('mysql2')->beginTransaction();
        try {
            $group_number = $request->group_number;
            $vendor = $request->vendor;
            $desc = $request->desc;
            foreach ($request->array as $key => $row):
                $data = explode(',',$row);
                $quotation_id = $data[0];
                $pr_data_id = $data[1];
                $pr_id = $data[2];
                $demandQty = $request->qtyDemand[$key];
                $remainingQty = $request->qtyRemaining[$key];
                $data = array
                (
                    'quotation_status'    => 1,
                    'vendor' =>  $vendor,
                    'qty' =>  $demandQty,
                    'description'=>$desc
                );
                $quott_data_id =  DB::Connection('mysql2')->table('quotation as a')
                    ->join('quotation_data as b', 'a.id', '=', 'b.master_id')
                    ->select('b.id')
                    ->where('a.vendor_id', $vendor)
                    ->where('a.group_number', $group_number)
                    ->where('b.pr_data_id', $pr_data_id)->value('id');
                // dd($quott);
                $quotData = DB::Connection('mysql2')->table('quotation_data')
                    ->where('id',$quott_data_id);
                $quotData->update($data);

                //$getDemandDataDetail = DB::connection

                
                if($demandQty >= $remainingQty){
                    DB::Connection('mysql2')->table('demand_data')
                    ->where('id',$pr_data_id)
                    ->update(['quotation_id'=>$quott_data_id,'demand_complete_status' => 2]);    
                }else{
                    DB::Connection('mysql2')->table('demand_data')
                        ->where('id',$pr_data_id)
                        ->update(['quotation_id'=>$quott_data_id]);
                }


                
                $this->check_quotation_update($pr_id);


            endforeach;

            // $voucher_no = 'Quotation Against '.$pr_no;
            // $subject = 'Purchase Quotation Approved For '.$pr_no;
            // NotificationHelper::send_email('Purchase Quotation','Approve',$dept_id,$voucher_no,$subject,$p_type);
            // echo 'Done';
            DB::Connection('mysql2')->commit();
                // return            [0=> $request->quotation_master_id, 1=> Quotation::find($request->quotation_master_id)->group_number];
            Session::flash('openSummarModal', [0=> $request->quotation_master_id, 1=> Quotation::find($request->quotation_master_id)->group_number]);
        } catch (\Exception $e) {
            DB::Connection('mysql2')->rollback();
            echo "EROOR"; //die();
            dd($e->getMessage());
        }
    }
    

    public function multipleReverse(Request $request){
        foreach ($request->reverseArray as $key => $row):
            $group_no = $request->group_no_array[$key];
            $damand_data_id = $request->damand_data_id_array[$key];
            $quotation_data_vendor = $request->quotation_data_vendor_array[$key];
            $quotation_data_id = $request->quotation_data_id_array[$key];


            $quott_data_id =  DB::Connection('mysql2')->table('quotation as a')
                ->join('quotation_data as b', 'a.id', '=', 'b.master_id')
                ->select('b.id')
                ->where('a.vendor_id', $quotation_data_vendor)
                ->where('a.group_number', $group_no)
                ->where('b.pr_data_id', $damand_data_id)->value('id');

            $quotation_data = Quotation_Data::find($quott_data_id);
            $quotation_data->update([
                'quotation_status' => 0,
                'vendor' =>  0,
                'qty' =>  0,
                'description' => ""
            ]);
            $demand_data = DemandData::find($damand_data_id);
            $demand_data->update([
                'quotation_id' => 0,
                'demand_complete_status' => 1
            ]);
            Demand::find($demand_data->master_id)->update(['quotation_approve' => 0,'demand_complete_status' => 1]);
            ReverseLog::create([
                'username' => Auth::user()->username,
                'supplier_id' => $quotation_data_vendor,
                'quotation_data_id' => $quotation_data_id,
            ]);

        endforeach;
    }

    public function reverseQuotation(Request $request)
    {
        $quott_data_id =  DB::Connection('mysql2')->table('quotation as a')
                ->join('quotation_data as b', 'a.id', '=', 'b.master_id')
                ->select('b.id')
                ->where('a.vendor_id', $request->quotation_data_vendor)
                ->where('a.group_number', $request->group_no)
                ->where('b.pr_data_id', $request->damand_data_id)->value('id');
        // dd($quott_data_id);
        DB::Connection('mysql2')->beginTransaction();
        try {
            // return Auth::user();
            $quotation_data = Quotation_Data::find($quott_data_id);
            $quotation_data->update([
                'quotation_status' => 0,
                'vendor' =>  0,
                'qty' =>  0,
                'description' => ""
            ]);
            $demand_data = DemandData::find($request->damand_data_id);
            $demand_data->update([
                'quotation_id' => 0,
                'demand_complete_status' => 1
            ]);
            Demand::find($demand_data->master_id)->update(['quotation_approve' => 0,'demand_complete_status' => 1]);
            ReverseLog::create([
                'username' => Auth::user()->username,
                'supplier_id' => $request->quotation_data_vendor,
                'quotation_data_id' => $request->quotation_data_id,
            ]);

            DB::Connection('mysql2')->commit();
            $quotationMaster = Quotation::find($quotation_data->master_id);
            Session::flash('openSummarModal', [0=> $quotationMaster->id, 1=> $quotationMaster->group_number]);

        } catch (Exception $th) {
            DB::Connection('mysql2')->rollback();
            echo $th->getLine()."<br>";
            echo $th->getMessage()."<br>";
            dd($th);
        }
    }

    public function check_quotation_update($id = null)
    {
        $demand = DB::Connection('mysql2')->table('demand_data')->where('master_id',$id)->where('demand_complete_status',1)->count();
        if ($demand == 0):
            DB::Connection('mysql2')->table('demand')->where('id',$id)->update(['quotation_approve' => 1,'demand_complete_status' => 2]);
        endif;
    }

    public function delete_quotation(Request $request)
    {
        try {
            $quotationData = Quotation_Data::where('master_id', $request->id)->where('status', 1);
            if ($quotationData->where('vendor', '!=', 0)->count() > 0) {
                return response()->json(['status' => 'error', "message" => "Cannot remove approved quotation"]);
            }
            // dd($request->id);
            $quotationData->where('vendor', 0)->update(['status' => 0]);
            Quotation::find($request->id)->update(['status' => 0]);
            return response()->json(['status' => 'Success', "message" => "Successfully Deleted"]);
        } catch (Exception $th) {
            return response()->json(['status' => 'error', "message" => $th->getMessage()]);
        }
    }

    public function edit_quotation($q_id)
    {
        $quotation = Quotation::find($q_id);
        $quotationData = Quotation_Data::where('master_id', $quotation->id)->where('status', 1);
        if ($quotationData->where('vendor', '!=', 0)->count() > 0) {
            return response()->json(['status' => 'error', "message" => "Quotation Againts This PR Alreday Approved"]);
        }
        return view($this->page, compact('quotation'));
    }
    public function new_create_quotation()
    {
        return view('Purchase.Quotation.newQuotationForm');
    }

    public function new_create_quotation_form(Request $request)
    {
        $ids = $request->ids;
        $request_data = DB::Connection('mysql2')->table('demand as a')
            ->join('demand_data as b', 'a.id', '=', 'b.master_id')
            ->select('b.*', 'qty', 'a.company_location_id')
            ->where('a.status', 1)
            ->whereIn('a.id', $ids)
            ->where('b.status', 1)
            ->where('b.cancel_status', 1)
            ->where('b.demand_complete_status', 1)
            ->get();
        // echo "<pre>";
        // print_r($request_data);
        // return;
        $voucher_no = $this->quotation_no(date('m'), date('y'),$request_data[0]->company_location_id??1);
        return view('Purchase.Quotation.newCreateQuotationForm', compact('voucher_no', 'request_data', 'ids'));
    }

    public function new_insert_quotation(Request $request)
    {
        // dd($request->all());
        if ($this->check_pr_status($request->pr_id) > 0) :
            return redirect()->back()->with('error', 'Quotation Againts This PR Alreday Approved');
        endif;

        DB::Connection('mysql2')->beginTransaction();
        $voucher_no = $this->quotation_no(date('m'), date('y'), $request->company_location_id);
        try {
            $quotation = new Quotation();

            $quotation->description = $request->description;
            $quotation->voucher_no = $voucher_no;
            $quotation->voucher_date = $request->demand_date;
            $quotation->vendor_id = $request->supplier;
            $quotation->ref_no = $request->ref_no;
            $quotation->company_location_id = $request->company_location_id;
            $quotation->gst = $request->sales_taxx;
            $quotation->gst_amount = CommonHelper::check_str_replace($request->sales_amount_td);
            $quotation->date = date('Y-m-d');
            $quotation->status = 1;
            $quotation->username = Auth::user()->name;
            $quotation->prepare_username = Auth::user()->name;
            $file = Input::file('file');
            // $file = Input::file('attachment');
            // if (isset($file)) {
                //     $newfilename = date('dmYHis') . str_replace(" ", "", basename($file->getClientOriginalName()));
                //     $file->move(public_path('uploads/attachement'), $newfilename);
                //     $quotation->attachment = 'public/uploads/attachement/' . $newfilename;
                // }
            $quotation->save();
            if (isset($file)) {
                foreach ($file as $key => $value) {
                    $newfilename = date('dmYHis') . str_replace(" ", "", basename($value->getClientOriginalName()));
                    $value->move(public_path('uploads/attachement'), $newfilename);

                    $attachment =  new Attachement();
                    $attachment->image_src = 'public/uploads/attachement/' . $newfilename;
                    $attachment->status = 1;
                    $quotation->comments()->save($attachment);
                }
            }
            $master_id = $quotation->id;

            $quotation_data = $request->net_amount;
            foreach ($quotation_data  as $key => $row) :
                $remainingQty = $request->remaining_qty[$key];
                $quotationQty = $request->quotation_qty[$key];
                $demandQty = $request->demand_qty[$key];
                $prDataId = $request->pr_data_id[$key];
                $quotation_data = new Quotation_Data();
                $quotation_data = $quotation_data->SetConnection('mysql2');
                $quotation_data->master_id = $master_id;
                $quotation_data->voucher_no = $voucher_no;
                $quotation_data->pr_id = $request->pr_id[$key];
                $quotation_data->pr_data_id = $prDataId;
                $quotation_data->sub_item_id = $request->input('sub_item_id')[$key];
                $quotation_data->sub_item_desc = $request->input('sub_item_desc')[$key];
                $quotation_data->demand_qty = $request->input('demand_qty')[$key];
                //$quotation_data->qty = $request->input('quotation_qty')[$key];
                $quotation_data->rate = $request->input('rate')[$key];
                $quotation_data->amount = $request->input('amount')[$key];
                $quotation_data->discount_percent = $request->input('discount_percent')[$key];
                $quotation_data->discount_amount = $request->input('discount_amount')[$key];
                $quotation_data->net_amount = $request->input('net_amount')[$key];
                $quotation_data->save();
                if($quotationQty == $remainingQty){
                    //DB::connection('mysql2')->table('demand_data')->where('id',$prDataId)->update(['demand_complete_status' => 2]);
                }

                $last_purchse_data['quotation_id'] = $master_id;
                $last_purchse_data['quotation_data_id'] = $quotation_data->id;
                $last_purchse_data['last_purchase_id'] = $request->input('last_purchase_id')[$key];
                $last_purchse_data['last_purchase_request_id'] = $request->input('last_purchase_request_id')[$key];
                $last_purchse_data['last_purchase_request_no'] = $request->input('last_purchase_request_no')[$key];
                $last_purchse_data['last_purchase_date'] = $request->input('last_purchase_date')[$key];
                $last_purchse_data['last_purchase_rate'] = $request->input('last_purchase_rate')[$key];
                $last_purchse_data['last_supplier_name'] = $request->input('last_supplier_name')[$key];
                $last_purchse_data['last_supplier_id'] = $request->input('last_supplier_id')[$key];
                $last_purchse_data['last_item_description'] = $request->input('last_item_description')[$key];
                $last_purchse_data['status'] = 1;
                $last_purchse_data['username'] = Auth::user()->name;
                $last_purchse_data['date'] = date('Y-m-d');
                $last_purchse_data['time'] = date('H:i:s');
                DB::connection('mysql2')->table('last_purchase_data')->insert($last_purchse_data);

            endforeach;
            DB::Connection('mysql2')->commit();
            return "success";
        } catch (Exception $ex) {
            DB::rollBack();
            dd($ex);
            // return self::index($request)->withErrors($ex->getMessage());
        }
        return redirect('quotation/quotation_list')->with('message', 'Quotation Successfully Saved');
    }

    public function generateGroupNumber(Request $request)
    {

        $str = Quotation::select(DB::raw('MAX(group_number) as group_number'))->first()->group_number;
        $str = ($str != null)? sprintf("%'03d", $str + 1) : sprintf("%'03d", 1);
        // dd($str);
        foreach ($request->id as $value) {
            Quotation::where('voucher_no', $value)->update(['group_number'=>$str]);
        }
    }

    public function getPoNoList()
    {
        return QuotationHelper::approvedPRForQuotation(request()->get('ids'));
    }


    public function quotationApproval(Request $request){
        
        // dd($request->all());
        $quotation = Quotation::where([['group_number', $request->groupNumber], ['status', 1]])->get();
        $filNames = null;
        $date = date('d-m-Y h:i A');
        if ($request->type == 'approved_remark') {
            $file = Input::file('approved_attachment');
            if (isset($file)) {
                $newfilename = date('dmYHis') . str_replace(" ", "", basename($file->getClientOriginalName()));
                $file->move(public_path('uploads/attachement'), $newfilename);
                $filNames= 'public/uploads/attachement/' . $newfilename;
            }
        }
        foreach ($quotation as $value) {
            if ($request->type == 'prepare_remark') {
                $value->prepare_remark = $request->description;
                $value->prepare_username = Auth::user()->name; 
                $value->prepare_date =$date; 
            }elseif ($request->type == 'checked_remark') {
                $value->checked_remark = $request->description;
                $value->checked_username = Auth::user()->name;
                $value->checked_date =$date; 
            }elseif ($request->type == 'audited_remark') {
                $value->audited_remark = $request->description;
                $value->audited_username = Auth::user()->name;
                $value->audited_date =$date; 
            }elseif ($request->type == 'approved_remark') {
                $value->approved_attachment = $filNames;
                $value->approved_remark = $request->description;
                $value->approved_username = Auth::user()->name;
                $value->approved_date =$date; 
            }else {
              return "something went wrong";
            }
            $value->save();
        }
        return "updated";

    }


}
