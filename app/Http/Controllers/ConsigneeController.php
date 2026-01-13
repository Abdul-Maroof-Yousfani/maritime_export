<?php

namespace App\Http\Controllers;

use App\Models\Consignee;
use Illuminate\Http\Request;
use App\Helpers\ReuseableCode;
use App\Helpers\CommonHelper;
use Exception;
use Illuminate\Support\Facades\DB;

class ConsigneeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewConsigneeListAjax()
    {
        $edit = ReuseableCode::check_rights(445);
        $delete = ReuseableCode::check_rights(446);
        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($m);
       
        $response = Consignee::all();
        CommonHelper::reconnectMasterDatabase();
        $counter = 1;
        foreach ($response as $row) {
        ?>
            <tr id="remove<?php echo $row['id'] ?>">
                <td class="text-center"><?php echo $counter++; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td class="text-center">
                    <?php if ($edit == true) : ?>
                        <a href="<?php echo route('consigneeEditForm',['id'=> $row['id']]) ?>"  class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
                    <?php endif; ?>
                    <?php if ($delete == true) : ?>
                        <button type="button" class="btn btn-danger btn-xs" id="delete<?php echo $row['id'] ?>" onclick="delete_consignee('<?php echo $row['id'] ?>')"><span class="glyphicon glyphicon-trash"></span></button>
                    <?php endif; ?>
                </td>
            </tr>

            <script>
                function delete_consignee(id) {
                    if (confirm('Are You Sure ? You want to delete this recored...!')) {
                        var m = '<?php echo $m ?>';

                        $.ajax({
                            url: '<?php echo url('/')?>/export/consigneeDelete',
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
    public function viewConsigneeList()
    {
        return view('export.consignee.viewConsigneeList');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function consigneeStore(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
    try {
         
       $response = new Consignee;
       $response->name = $request->name;
       $response->save();
        DB::Connection('mysql2')->commit();
        return redirect()->route('viewConsigneeList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function consigneeCreateForm()
    {
        return view('export.consignee.consigneeCreateForm');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function consigneeEditForm($id)
    {
        $response = Consignee::find($id);
       return view('export.consignee.consigneeEditForm',compact('response'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function consigneeUpdate(Request $request, $id)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
             
            $response = Consignee::find($id);
            $response->name = $request->name;
            $response->save();
             DB::Connection('mysql2')->commit();
             return redirect()->route('viewConsigneeList');
             } catch (Exception $ex) {
     
                 DB::rollBack();
                 dd($ex);
                 $ex->getCode();
             }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function consigneeDelete(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
             
            $response = Consignee::find($request->id);
            $response->delete();
             DB::Connection('mysql2')->commit();
             return $request->id;
             } catch (Exception $ex) {
     
                 DB::rollBack();
                 dd($ex);
                 $ex->getCode();
             }
    }
}


