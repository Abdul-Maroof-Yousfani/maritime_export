<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Helpers\ReuseableCode;
use App\Helpers\CommonHelper;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CurrencyRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewRateListAjax()
    {
        $edit = ReuseableCode::check_rights(447);
        $delete = ReuseableCode::check_rights(448);
        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($m);
       
        $response =Currency::where('status',1)->get();
        CommonHelper::reconnectMasterDatabase();
        $counter = 1;
        foreach ($response as $row) {
        ?>
            <tr id="remove<?php echo $row['id'] ?>">
                <td class="text-center"><?php echo $counter++; ?></td>
                <td class="text-center"><?php echo $row['curreny']; ?></td>
                <td class="text-center"><?php echo $row['rate']; ?></td>
                <td class="text-center">
                    <?php if ($edit == true) : ?>
                        <a href="<?php echo route('rateEditForm',['id'=> $row['id']]) ?>"  class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
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
                            url: '/garibsons/export/rateDelete',
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
    public function viewRateList()
    {
        return view('rateconversion.viewRateList');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rateStore(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
    try {
         
       $response = new Currency;
       $response->curreny = $request->name;
       $response->rate = $request->rate;
       $response->status = 1;
       $response->date = date('Y-m-d');
       $response->username =Auth::user()->name;
       $response->save();
        DB::Connection('mysql2')->commit();
        return redirect()->route('viewRateList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function rateCreateForm()
    {
        return view('rateconversion.rateCreateForm');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IncoTerm  $incoTerm
     * @return \Illuminate\Http\Response
     */
    public function rateEditForm($id)
    {
        $response = Currency::find($id);
       return view('rateconversion.rateEditForm',compact('response'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IncoTerm  $incoTerm
     * @return \Illuminate\Http\Response
     */
    public function rateUpdate(Request $request, $id)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
             
            $response = Currency::find($id);
            $response->curreny = $request->name;
            $response->rate = $request->rate;
            $response->status = 1;
            $response->date = date('Y-m-d');
            $response->save();
             DB::Connection('mysql2')->commit();
             return redirect()->route('viewRateList');
             } catch (Exception $ex) {
     
                 DB::rollBack();
                 dd($ex);
                 $ex->getCode();
             }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IncoTerm  $incoTerm
     * @return \Illuminate\Http\Response
     */
    public function rateDelete(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
        
            $data['status'] = 0;
            DB::Connection('mysql2')->table('currency')->where('id', $request->id)->update($data);
             DB::Connection('mysql2')->commit();
             return $request->id;
             } catch (Exception $ex) {
     
                 DB::rollBack();
                 dd($ex);
                 $ex->getCode();
             }
    }
}
