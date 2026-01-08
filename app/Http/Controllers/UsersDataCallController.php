<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use DB;
use Config;
use App\Models\MainMenuTitle;
use App\Models\Menu;
use Illuminate\Support\Facades\Session;
class UsersDataCallController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   	public function viewMainMenuTitleList(){
		$MainMenuTitles = new MainMenuTitle;
		$MainMenuTitles = $MainMenuTitles::where('status', '=', '1')->get();
		$counter = 1;
		foreach($MainMenuTitles as $row){
	?>
		<tr>
			<td class="text-center"><?php echo $counter++;?></td>
			<td><?php echo $row['main_menu_id'];?></td>
			<td><?php echo $row['title'];?></td>
			<td><a onclick="showDetailModelMasterTable('<?php Session::get('run_company') ?>','/udc/editMainMenuTitle?id=<?php echo $row['id'] ?>','1','<?php echo $row['id'] ?>','','', 'MainMenuTitle','Edit Main Menu Title')" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a></td>
		</tr>
	<?php
		}
	}

	public function editMainMenuTitle(Request $request)
	{
		$menu = MainMenuTitle::where('id', $request->id)->first();
		return view('Users.editMainMenuTitle', compact('menu'));
	}
	
	public function viewSubMenuList(){
		$Menus = new Menu;
		$Menus = $Menus::where('status', '=', '1')->get();
		$counter = 1;
		foreach($Menus as $row){
	?>
		<tr>
			<td class="text-center"><?php echo $counter++;?></td>
			<td><?php echo $row['m_parent_code'];?></td>
			<td><?php echo $row['name'];?></td>
			<td><a onclick="showDetailModelMasterTable('<?php Session::get('run_company') ?>','/udc/editSubMenu?id=<?php echo $row['id'] ?>','1','<?php echo $row['id'] ?>','','', 'Menu','Edit Sub Menu Title')" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a></td>
		</tr>
	<?php
		}
	}

	public function editSubMenu(Request $request)
	{
		$MainMenuTitles = MainMenuTitle::where('status',1)->get();
		$subMenu = Menu::where('id', $request->id)->first();
		// dd($menu);
		return view('Users.editSubMenu', compact('subMenu','MainMenuTitles'));
	}
}
