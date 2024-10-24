<?php

namespace App\Http\Controllers\Admin;

// use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

use Facades\Services\UserService;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['downloadFile']);
    }
	public function getAllUsers(){
		$users = User::All();
		return $users;
	}
	public function onDeleteUser($id){

		$user = User::find($id);
		$user->delete();
		return true;
 

	}
	public function getUserById($id){
		$user = User::find($id);
		return $user;
	}

	public function getUserDetails($id){
		return UserService::getUserDetails($id);
	}
	public function resetUserData($id){
		return UserService::resetUserData($id);
	}


	public function updateStatus(Request $request){
		$user = User::find($request->id);
		$user->is_active = $request->status;
		$user->save();
		return true;
	}



	public function downloadFile(Request $request)
	{
		$type = $request->get('reportType'); 
		return Excel::download(new UsersExport($type), 'users.csv');
	}
}