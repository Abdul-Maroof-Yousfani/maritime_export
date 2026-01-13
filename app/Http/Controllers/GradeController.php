<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Helpers\ReuseableCode;
use App\Helpers\CommonHelper;
use Exception;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewGradeListAjax()
    {
        $edit = ReuseableCode::check_rights(445);
        $delete = ReuseableCode::check_rights(446);
        $m = $_GET['m'];
        CommonHelper::companyDatabaseConnection($m);
       
        $response = Grade::all();
        CommonHelper::reconnectMasterDatabase();
        $counter = 1;
        foreach ($response as $row) {
        ?>
            <tr id="remove<?php echo $row['id'] ?>">
                <td class="text-center"><?php echo $counter++; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td class="text-center">
                    <?php if ($edit == true) : ?>
                        <a href="<?php echo route('gradeEditForm',['id'=> $row['id']]) ?>"  class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
                    <?php endif; ?>
                    <?php if ($delete == true) : ?>
                        <button type="button" class="btn btn-danger btn-xs" id="delete<?php echo $row['id'] ?>" onclick="delete_grade('<?php echo $row['id'] ?>')"><span class="glyphicon glyphicon-trash"></span></button>
                    <?php endif; ?>
                </td>
            </tr>

            <script>
                function delete_grade(id) {
                    if (confirm('Are You Sure ? You want to delete this recored...!')) {
                        var m = '<?php echo $m ?>';

                        $.ajax({
                            url: '<?php echo url('/')?>/export/gradeDelete',
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
    public function viewGradeList()
    {
        return view('export.grade.viewGradeList');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function gradeStore(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
    try {
         
       $response = new Grade;
       $response->name = $request->name;
       $response->save();
        DB::Connection('mysql2')->commit();
        return redirect()->route('viewGradeList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function gradeCreateForm()
    {
        return view('export.grade.gradeCreateForm');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gradeEditForm($id)
    {
        $response = Grade::find($id);
       return view('export.grade.gradeEditForm',compact('response'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gradeUpdate(Request $request, $id)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
             
            $response = Grade::find($id);
            $response->name = $request->name;
            $response->save();
             DB::Connection('mysql2')->commit();
             return redirect()->route('viewGradeList');
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
    public function gradeDelete(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
             
            $response = Grade::find($request->id);
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


