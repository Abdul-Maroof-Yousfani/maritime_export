<?php

namespace App\Http\Controllers;

use App\CompanyLocation;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
use App\Helpers\NotificationHelper;
use App\Models\Department;
use App\Models\EmailNotify;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    /**
     * Show user online status.
     *
     */
    public function check_status()
    {
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id)):
                echo "User " . $user->name . " is online.";
                echo '</br>';
            endif;


        }
    }

    public function add_notifications()
    {
        return view('Users.add_notifications');
    }

    public function get_behavior(Request $request)
    {
      
        $steps =   $request->steps;
        $behavior = NotificationHelper::get_behvaior($steps);?>
        <option value="">Select</option>
        <?php   foreach($behavior as $row):?>
        <option value="<?php echo $row->id ?>"><?php echo $row->name ?></option>
       <?php endforeach;

    }

    public function get_notification_data(Request $request)
    {
    
        $notifications_data = NotificationHelper::get_notification_data($request->all());
        return view('Users.notifications_data',compact('notifications_data'));
    }


    public function insert_notifications(Request $request)
    {
       $id= $request->id;
       $notification = new EmailNotify();

       if ($id!=0):
        $notification = $notification->find($id);
       endif;
       $notification->step_id = $request->step_id;
       $notification->behavior_id = $request->behavior;
       $notification->voucher_type = $request->v_type;
       $notification->dept_id = $request->dept;;
       $notification->email_1 = $request->email_1;;
       $notification->email_2 = $request->email_2;;
       $notification->body_1 = $request->body_1;;
       $notification->body_2 = $request->body_2;;
       $notification->email_3 = $request->email_3;;
       $notification->body_3 = $request->body_3;;
       $notification->save();

       return redirect('users/notifications_list');


    }

    public function notifications_list()
    {
        $notifications_data = NotificationHelper::notify_list();
        return view('Users.notifications_list',compact('notifications_data'));
    }

    public function warehouseRight()
    {
        return view('Users.warehouseRight');
    }

    public function UserLocation(Request $request)
    {
        $id = User::find($request->id)->warehouse;
        $ids = explode(',', $id);
        $html = "";
        foreach(CommonHelper::get_all_warehouse() as $wh) {
            $selected = in_array($wh->id, $ids) ? "selected" : "";
            $html .= '<option ' . $selected . ' value="' . $wh->id . '">' . $wh->name . '</option>';
        }
        return $html;

    }

    public function UserCompanyLocation(Request $request)
    {
        $id = User::find($request->id)->company_location;
        $ids = explode(',', $id);
        $html = "";
        $company_locations = CompanyLocation::get();
        foreach($company_locations as $wh) {
            $selected = in_array($wh->id, $ids) ? "selected" : "";
            $html .= '<option ' . $selected . ' value="' . $wh->id . '">' . $wh->location_name . '</option>';
        }
        return $html;

    }

    public function UserDepartment(Request $request)
    {
        $id = User::find($request->id)->department_id;
        $ids = explode(',', $id);
        $html = "";
        $departments = Department::where([['status', '=', '1'], ])->select('id','department_name')->orderBy('id')->get();
        foreach ($departments as $key => $value) {
            $subdepartments = DB::select('select `id`,`sub_department_name` from `sub_department` where `department_id` =' . $value->id . '');
            foreach($subdepartments as $key2 => $y2) {
                $selected = in_array($y2->id, $ids) ? "selected" : "";
                $html .= '<option ' . $selected . ' value="' . $y2->id . '">' . $y2->sub_department_name . '</option>';
            }
        }
       
        return $html;

    }

    public function warehouseRightPost(Request $request)
    {
        $request['warehouse'] = implode(',',$request->warehouse);
        // dd($request->all());
        User::find($request->users)->update(['warehouse'=>$request->warehouse]);
        // User::find($request->users)->update(['company_location'=>$request->warehouse]);
        Session::flash('dataInsert',"Warehouse Assign Successfully");
        return redirect()->back();
    }

    public function addUserDetail(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => ['required','string'],
            'company_id'=> ['required'],
            'email'=> ['required','unique:mysql.users,email'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make('123456'),
            'acc_type'=> $request->type == 1? 'client' : 'user',
            'emp_id'  => User::orderBy('id','desc')->first()->id + 1,
            'emp_code'=> User::orderBy('id','desc')->first()->id + 1,
            'created_at'=> date('Y'),
            'company_id'=> $request->company_id,
            'identity'=> '123456',
        ]);
        Session::flash('dataInsert', "User Acount Create Successfully");
        if($request->type == 1){
            return redirect('/finance/usersList?m='.Session::get('run_company'));
        }else {
            return redirect('/finance/viewCostCenterList?m='.Session::get('run_company').'&user_id='.$user->emp_code.'&company_id='.$request->company_id);
        }
    }

    public function updateCompactMode(Request $request) {
        $user = User::find(Auth::user()->id);
        $user->update(['compact_mode'=>$request->compact_mode]);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
    }
}