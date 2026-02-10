<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Helpers\ReuseableCode;
use App\Helpers\CommonHelper;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bankList()
    {
       return view('bank.bankList');
    }
       /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function viewbankList(Request $request)
    {

        $edit=ReuseableCode::check_rights(439);
        $delete=ReuseableCode::check_rights(440);
        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($m);
       
        $response = Bank::where('status',1)->get();
        CommonHelper::reconnectMasterDatabase();
        $counter = 1;
        foreach ($response as $row) {
        ?>
            <tr id="remove<?php echo $row['id'] ?>">
                <td class="text-center"><?php echo $counter++; ?></td>
                <td class="text-center"><?php echo $row['account_title']; ?></td>
                <td class="text-center"><?php echo $row['bank_name']; ?></td>
                <td class="text-center"><?php echo $row['IBAN_no']; ?></td>
                <td class="text-center"><?php echo $row['account_no']; ?></td>
                <td class="text-center"><?php echo $row['swift_code']; ?></td>
                <td class="text-center"><?php echo $row['bank_address']; ?></td>
                <td class="text-center">
                    <?php if ($edit == true) : ?>
                        <a href="<?php echo route('editBankForm',['id'=> $row['id']]) ?>"  class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
                    <?php endif; ?>
                    <?php if ($delete == true) : ?>
                        <button type="button" class="btn btn-danger btn-xs" id="delete<?php echo $row['id'] ?>" onclick="delete_cate('<?php echo $row['id'] ?>')"><span class="glyphicon glyphicon-trash"></span></button>
                    <?php endif; ?>
                </td>
            </tr>

            <script>
                function delete_cate(id) {
                    if (confirm('Are You Sure ? You want to delete this recored...!')) {
                        var m = '<?php echo $m ?>';

                        $.ajax({
                            url: '/garibsons/deleteBank',
                            type: 'Get',
                            data: {
                                id: id
                            },

                            success: function(response) {


                                $('#remove' + response).remove();
                            }
                        });
                    } else {}
                }
            </script>
            <?php
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createBankForm()
    {
        $banks = Bank::doesntHave('Correspondent')->wherenull('beneficiary_id')->where('status', 1)->get();
        return view('bank.createBankForm',compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bankFormStore(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {

            $parent_code = '1-1-8';
            $max_id = DB::Connection('mysql2')->selectOne('SELECT max(`id`) as id  FROM `accounts` WHERE `parent_code` LIKE \''.$parent_code.'\' and status=1')->id;
            if($max_id == ''){
                $code = $parent_code.'-1';
            }else{
                $max_code2 = DB::Connection('mysql2')->selectOne('SELECT `code`  FROM `accounts` WHERE `id` LIKE \''.$max_id.'\' and status=1')->code;
                $max_code2;
                $max = explode('-',$max_code2);
                $code = $parent_code.'-'.(end($max)+1);
            }

            $level_array = explode('-',$code);
            $counter = 1;
            foreach($level_array as $level):
                $data1['level'.$counter] = $level;
                $counter++;
            endforeach;
            $data1['code'] = $code;
            $data1['name'] = $request->name.' - ('.$request->account_no.')';
            $data1['parent_code'] = $parent_code;
            $data1['username'] 		 	= auth()->user()->username;
            $data1['date']     		  = date("Y-m-d");
            $data1['time']     		  = date("H:i:s");
            $data1['action']     		  = 'create';
            $data1['operational']		= 1;
            $data1['type']		= 4;


            $acc_id = DB::Connection('mysql2')->table('accounts')->insertGetId($data1);
        
             
            $bank = new Bank;
            $bank->acc_id = $acc_id;
            $bank->bank_name = $request->name;
            $bank->account_title = $request->account_title;
            $bank->IBAN_no = $request->ibn;
            $bank->account_no = $request->account_no;
            $bank->swift_code = $request->swift_code;
            $bank->bank_address = $request->Address;
            $bank->status = 1;
            $bank->username = Auth::user()->name;
            $bank->save();
            DB::Connection('mysql2')->commit();
      return redirect()->route('bankList');
      } catch (Exception $ex) {

          DB::rollBack();
          dd($ex);
          $ex->getCode();
      }


    }

 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function editBankForm($id)
    {
        $response = Bank::find($id);
        return view('bank.editBankForm',compact('response'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function updateBankForm(Request $request, $id)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
             
            $bank = Bank::find($id);
            $bank->bank_name = $request->name;
            $bank->account_title = $request->account_title;
            $bank->IBAN_no = $request->ibn;
            $bank->account_no = $request->account_no;
            $bank->swift_code = $request->swift_code;
            $bank->bank_address = $request->Address;
            $bank->status = 1;
            $bank->username = Auth::user()->name;
            $bank->save();

            $account = DB::Connection('mysql2')->table('accounts')->where('id',$bank->acc_id)->update(['name'=>$request->name.' - ('.$request->account_no.')']);
            DB::Connection('mysql2')->commit();
      return redirect()->route('bankList');
      } catch (Exception $ex) {

          DB::rollBack();
          dd($ex);
          $ex->getCode();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function deleteBank(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
        
            $data['status'] = 0;
            DB::Connection('mysql2')->table('banks')->where('id', $request->id)->update($data);
            
            DB::Connection('mysql2')->commit();
             return $request->id;
             } catch (Exception $ex) {
     
                 DB::rollBack();
                 dd($ex);
                 $ex->getCode();
             }
    }
    public function getCorrespondentBankDetail(Request $request){
        return Bank::where('beneficiary_id', $request->id)->where('status', 1)->first();
    }
}
