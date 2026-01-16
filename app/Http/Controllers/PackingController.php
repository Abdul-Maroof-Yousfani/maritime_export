<?php

namespace App\Http\Controllers;

use App\Models\Packing;
use Illuminate\Http\Request;
use App\Helpers\ReuseableCode;
use App\Helpers\CommonHelper;
use Exception;
use Illuminate\Support\Facades\DB;

class PackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewPackingListAjax()
    {
        $edit = ReuseableCode::check_rights(445);
        $delete = ReuseableCode::check_rights(446);
        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($m);
       
        $response = Packing::all();
        CommonHelper::reconnectMasterDatabase();
        $counter = 1;
        foreach ($response as $row) {
        ?>
            <tr id="remove<?php echo $row['id'] ?>">
                <td class="text-center"><?php echo $counter++; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td class="text-center">
                    <?php if ($edit == true) : ?>
                        <a href="<?php echo route('packingEditForm',['id'=> $row['id']]) ?>"  class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
                    <?php endif; ?>
                    <?php if ($delete == true) : ?>
                        <button type="button" class="btn btn-danger btn-xs" id="delete<?php echo $row['id'] ?>" onclick="delete_packing('<?php echo $row['id'] ?>')"><span class="glyphicon glyphicon-trash"></span></button>
                    <?php endif; ?>
                </td>
            </tr>

            <script>
                function delete_packing(id) {
                    if (confirm('Are You Sure ? You want to delete this recored...!')) {
                        var m = '<?php echo $m ?>';

                        $.ajax({
                            url: '<?php echo url('/')?>/export/packingDelete',
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
    public function viewPackingList()
    {
        return view('export.packing.viewPackingList');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function packingStore(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
    try {
         
       $response = new Packing;
       $response->name = $request->name;
       $response->save();
        DB::Connection('mysql2')->commit();
        return redirect()->route('viewPackingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function packingCreateForm()
    {
        return view('export.packing.packingCreateForm');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function packingEditForm($id)
    {
        $response = Packing::find($id);
       return view('export.packing.packingEditForm',compact('response'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function packingUpdate(Request $request, $id)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
             
            $response = Packing::find($id);
            $response->name = $request->name;
            $response->save();
             DB::Connection('mysql2')->commit();
             return redirect()->route('viewPackingList');
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
    public function packingDelete(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
             
            $response = Packing::find($request->id);
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




