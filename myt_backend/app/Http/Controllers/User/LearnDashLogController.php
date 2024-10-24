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

class LearnDashLogController extends Controller
{
    public function saveLearnDashLessonLog($wp_user_id)
    {
        return BootCampAnalyticService::saveLearnDashLessonLog($wp_user_id);
    }
    public function saveLearnDashQuizLog($wp_user_id)
    {
        return BootCampAnalyticService::saveLearnDashQuizLog($wp_user_id);
    }
    public function saveLearnDashLoggedInLog($wp_user_id)
    {
        return BootCampAnalyticService::saveLearnDashLoggedInLog($wp_user_id);
    }

}