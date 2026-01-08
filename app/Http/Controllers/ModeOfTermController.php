<?php

namespace App\Http\Controllers;

use App\Models\ModeOfTerm;
use Illuminate\Http\Request;
use App\Helpers\ReuseableCode;
use App\Helpers\CommonHelper;
use Exception;
use Illuminate\Support\Facades\DB;

class ModeOfTermController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function modeoftermListAjax()
    {
        $edit = ReuseableCode::check_rights(443);
        $delete = ReuseableCode::check_rights(444);
        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($m);
       
        $response =ModeOfTerm::all();
        CommonHelper::reconnectMasterDatabase();
        $counter = 1;
        foreach ($response as $row) {
        ?>
            <tr id="remove<?php echo $row['id'] ?>">
                <td class="text-center"><?php echo $counter++; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td class="text-center">
                    <?php if ($edit == true) : ?>
                        <a href="<?php echo route('modeoftermEditForm',['id'=> $row['id']]) ?>"  class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
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
                            url: '/garibsons/export/modeoftermDelete',
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
    public function modeoftermList()
    {
        return view('export.modeofterm.modeoftermList');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function modeoftermStore(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
    try {
         
       $response = new ModeOfTerm;
       $response->name = $request->name;
       $response->remarks = $request->remarks;
       $response->save();
        DB::Connection('mysql2')->commit();
        return redirect()->route('modeoftermList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function modeoftermCreateForm()
    {
        return view('export.modeofterm.modeoftermCreateForm');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IncoTerm  $incoTerm
     * @return \Illuminate\Http\Response
     */
    public function modeoftermEditForm($id)
    {
        $response = ModeOfTerm::find($id);
       return view('export.modeofterm.modeoftermEditForm',compact('response'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IncoTerm  $incoTerm
     * @return \Illuminate\Http\Response
     */
    public function modeoftermUpdate(Request $request, $id)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
             
            $response = ModeOfTerm::find($id);
            $response->name = $request->name;
            $response->remarks = $request->remarks;
            $response->save();
             DB::Connection('mysql2')->commit();
             return redirect()->route('modeoftermList');
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
    public function modeoftermDelete(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
             
            $response = ModeOfTerm::find($request->id);
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
