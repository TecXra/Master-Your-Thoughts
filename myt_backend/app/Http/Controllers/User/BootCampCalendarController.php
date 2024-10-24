<?php

namespace App\Http\Controllers\User;

use Auth;
use Carbon\Carbon;
use App\Models\MytLog;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Facades\Services\BootCampAnalyticService;

class BootCampCalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function getAllLoggedInDates($user_id = null)
    {
        // $userObj = Auth::User();
        // if(isset($user_id)){
    	   //  $userObj = User::find($user_id);
        // }
        return BootCampAnalyticService::getAllLoggedInDates($user_id);
    }



    public function getWeeklyBootCampAnalyticsLog(Request $request)
    {
        $date = $request->get("date");
        $user_id = $request->get("user_id");
        return BootCampAnalyticService::getWeeklyBootCampAnalyticsLog($user_id,$date);
    }
    public function getAllBootCampAnalyticsLog(Request $request)
    {
        $user_id = $request->get("user_id");
        return BootCampAnalyticService::getAllBootCampAnalyticsLog($user_id);
    }
    public function saveHarmonizerActivityLog()
    {
        $userObj = Auth::User();
        return BootCampAnalyticService::saveHarmonizerActivityLog($userObj->id);
    }

}