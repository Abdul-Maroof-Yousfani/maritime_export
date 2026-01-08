<?php

namespace App\Http\Controllers;

use App\Models\ModeOfTransport;
use Illuminate\Http\Request;
use App\Helpers\ReuseableCode;
use App\Helpers\CommonHelper;
use Exception;
use Illuminate\Support\Facades\DB;

class ModeOfTransportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function modeOfTransportListAjax()
    {
        $edit = ReuseableCode::check_rights(441);
        $delete = ReuseableCode::check_rights(442);
        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($m);
       
        $response =ModeOfTransport::all();
        CommonHelper::reconnectMasterDatabase();
        $counter = 1;
        foreach ($response as $row) {
        ?>
            <tr id="remove<?php echo $row['id'] ?>">
                <td class="text-center"><?php echo $counter++; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td class="text-center">
                    <?php if ($edit == true) : ?>
                        <a href="<?php echo route('modeOfTransportEditForm',['id'=> $row['id']]) ?>"  class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
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
                            url: '/garibsons/export/modeOfTransportDelete',
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
    public function modeOfTransportList()
    {
        return view('export.modeoftransport.modeOfTransportList');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function modeOfTransportStore(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
    try {
         
       $response = new ModeOfTransport;
       $response->name = $request->name;
       $response->remarks = $request->remarks;
       $response->save();
        DB::Connection('mysql2')->commit();
        return redirect()->route('modeOfTransportList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function modeOfTransportCreateForm()
    {
        return view('export.modeoftransport.modeOfTransportCreateForm');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IncoTerm  $incoTerm
     * @return \Illuminate\Http\Response
     */
    public function modeOfTransportEditForm($id)
    {
        $response = ModeOfTransport::find($id);
       return view('export.modeoftransport.modeOfTransportEditForm',compact('response'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IncoTerm  $incoTerm
     * @return \Illuminate\Http\Response
     */
    public function modeOfTransportUpdate(Request $request, $id)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
             
            $response = ModeOfTransport::find($id);
            $response->name = $request->name;
            $response->remarks = $request->remarks;
            $response->save();
             DB::Connection('mysql2')->commit();
             return redirect()->route('modeOfTransportList');
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
    public function modeOfTransportDelete(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
             
            $response = ModeOfTransport::find($request->id);
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
