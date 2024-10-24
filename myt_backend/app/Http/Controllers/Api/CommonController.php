<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Facades\Services\CommonService;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function getUserDefaultThemeSettings(Request $request)
    {
        $user_id =  $request->user_id;
        return CommonService::getUserDefaultThemeSettings($user_id);
    }
    public function updateUserThemeSetting(Request $request)
    {
        $user_id = Auth::user()->id;
        return CommonService::updateUserThemeSetting($request->all(), $user_id);
    }
    public function getAllTimeZonesList()
    {
        return CommonService::getAllTimeZonesList();
    }
    public function getStatesList()
    {
        return config('MYT.states_list');
    }
    


}