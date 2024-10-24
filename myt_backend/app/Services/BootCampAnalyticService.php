<?php 

namespace Services;


use App\Models\BcaLog;
use App\Models\User;
use App\Models\TimeZone;
use App\Models\UserSetting;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\BCAAlgoActivity;
use Facades\Services\UserService;
use Facades\Services\CommonService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BootCampAnalyticService
{
    public function saveLearnDashLoggedInLog($wp_user_id)
    {
        $user_id = UserService::getMytUserIdByWPUserId($wp_user_id);
        $userObj = User::find($user_id);
        // saveBootCampAnalyticLog($user_id,getLoggedInBcaActivityId());
        $UserLoggedInDate = CommonService::saveUserLoggedInDate($userObj);
        return true;
    }
    public function getAllLoggedInDates($user_id)
    {
        $userObj = User::find($user_id);
        $logsArray = $userObj->mytLogs()->where('log_type', config('MYT.myt_log_type.loggedIn_at'))->get();

        $logsArrayGrouped = $logsArray->groupBy('time_zone_date');
        $formatedLogsDate = [];
        foreach ($logsArrayGrouped as $key => $log) {
            array_push($formatedLogsDate,['date'=>$key]);
        }
        return $formatedLogsDate;
    }

    public function saveLearnDashLessonLog($wp_user_id)
    {
        $user_id = UserService::getMytUserIdByWPUserId($wp_user_id);
        saveBootCampAnalyticLog($user_id,getLearnDashLecturesBcaActivityId());
        return true;
    }
    public function saveLearnDashQuizLog($wp_user_id)
    {
        $user_id = UserService::getMytUserIdByWPUserId($wp_user_id);
        saveBootCampAnalyticLog($user_id,getLearnDashExercisesBcaActivityId());
        return true;
    }
    public function saveHarmonizerActivityLog($user_id)
    {
        $harmonizerActivityLogs = BcaLog::where('bca_activity_id',getTheHarmonizerBcaActivityId())->get();
        if (count($harmonizerActivityLogs) == 0) {
            saveBootCampAnalyticLog($user_id,getTheHarmonizerBcaActivityId());
        }
        return true;
    }
    public function saveBootCampAnalyticLog($user_id,$bca_activity_id)
    {
        $bcaLog = BcaLog::create(['user_id'=>$user_id,'bca_activity_id'=>$bca_activity_id]);
        return $bcaLog;
    }


    public function getWeeklyBootCampAnalyticsLog($user_id,$selected_date)
    {

        $date = Carbon::parse($selected_date);
        $start = $date->startOfWeek()->toDateString();
        $end = $date->endOfWeek()->toDateString();


        $period = CarbonPeriod::create($start, $end);
        $datesList = [];
        $tableHeadCol=[];
        $tableRowsData=[];
        foreach ($period as $date) {
            $tempDateObj =[
                'date' => $date->format('Y-m-d'),
                'formated_date' => $date->format('m/d/Y'),
                'day' => strtoupper($date->format('l')),
            ];
            array_push($datesList,$tempDateObj);
            $tempHeadColObj = ['day' => $tempDateObj['day'],'date'=>$tempDateObj['formated_date']];
            if($tempDateObj['date'] == $selected_date){
                $tempHeadColObj["selected"] = true;
            }
            array_push($tableHeadCol,$tempHeadColObj);
        }

        $bcaAlgoActivity = BCAAlgoActivity::all();

        foreach ($bcaAlgoActivity as $key => $activity) {
            
            $activityDays = [];
            
            foreach ($datesList as $key => $date) {
                $tempObj = ['value'=>""];    
                $bcaLog = BcaLog::where('user_id',$user_id)->where('bca_activity_id',$activity->id)->whereDate('created_at', $date['date'])->first();
                if(isset($bcaLog)){
                    $tempObj['value'] = "*";
                    if($activity->id == getPointsOfFaithAndFuelBcaActivityId()){
                    $tempObj['celebration'] = true;
                    }
                }    
               array_push($activityDays,$tempObj);
            }    
            $tempTableRowsDataObj = [
                'activity_id'=> $activity->id,
                'discription'=> $activity->name,
                'days'=> $activityDays,
            ];            
            array_push($tableRowsData,$tempTableRowsDataObj);            
        }
        
        $noActivityAdon = [
            'discription'=> "No Activity",
            'days'=> [],
        ];            

        $tableFooterCol = []; 

        foreach ($datesList as $date_key => $date) {
            $noActivityFlag = true;
            foreach ($tableRowsData as $key => $rowData) {
                if($rowData['days'][$date_key]['value'] != ""){
                    $noActivityFlag = false;
                }
            }

            if($noActivityFlag){
                $noActivityAdon['days'][]=['value'=>"*"];
            }else{
                $noActivityAdon['days'][]=['value'=>""];
            }
            $algoResult = $this->applyBcaChartAlgo($user_id,$date);
            $tableFooterCol[]=$algoResult['text'];            

        }

        array_push($tableRowsData,$noActivityAdon);
            
        $data_set = [
            'tableHeadCol'=>$tableHeadCol,
            'tableRowsData'=>$tableRowsData,
            'tableFooterCol'=>$tableFooterCol,
        ];
        return $data_set;
    }



    public function applyBcaChartAlgo($user_id,$date)
    {
        $bcaLogs = BcaLog::where('user_id',$user_id)->whereDate('created_at', $date['date'])->get();
        $bcaAlgo = qualifyForBcaChartAlgo($bcaLogs);
        $data_set = [
            'text'=>$bcaAlgo->text,
            'image_url'=>$bcaAlgo->image_url,
        ];        
        return $bcaAlgo;
    }

    public function getAllBootCampAnalyticsLog($user_id)
    {
        $userSettingObj = UserSetting::where('user_id',$user_id)->first();
        $timeZoneObj = TimeZone::find($userSettingObj->time_zone);
        $offset = $timeZoneObj->relative_to_GMT;
        // $offset = '-15:00';
        // return $offset;
        $symbolArray = str_split($offset, 1);
        $temp = explode($symbolArray[0], $offset);        
        $timeArray = explode(':', $temp[1]);
        
        $symbol = $symbolArray[0];
        $hours = $timeArray[0];
        $minutes = $timeArray[1];

        $data_set = [];

        // return BcaLog::where('user_id',$user_id)->where('bca_activity_id', getPointsOfFaithAndFuelBcaActivityId())->get();

        // $groupedBCALogs = BcaLog::where('user_id',$user_id)->where('bca_activity_id', getPointsOfFaithAndFuelBcaActivityId())
        // ->get()
        // ->groupBy(function($query->created_at, $hours, $minutes) {
        //     return $query;
        //     return Carbon::parse($query)->addHours($symbol.$hours)->addMinutes($symbol.$minutes)->format('Y-m-d');
        // })
        // ->get();
        
        $groupedBCALogs = BcaLog::where('user_id',$user_id)->where('bca_activity_id', getPointsOfFaithAndFuelBcaActivityId())
        ->get();
        
        // return $symbol.$hours . '........' . $symbol.$minutes;

        for ($i=0; $i < count($groupedBCALogs); $i++) { 
            $groupedBCALogs[$i]['calendar_date'] = Carbon::parse($groupedBCALogs[$i]->created_at)->addHours($symbol.$hours)->addMinutes($symbol.$minutes)->format('Y-m-d');
        }

        $groupedBCALogs = $groupedBCALogs->groupBy('calendar_date');

        // return $groupedBCALogs;
        
        foreach ($groupedBCALogs as $date => $bcaLogs) {
            $tempObj = [
                'date'=> $date
            ];
            $algoResult = [];
            $bcaAlgo = qualifyForBcaChartAlgo($bcaLogs);
            $algoResult = [
                // 'text'=>$bcaAlgo->text,
                'text'=>'',
                'image_url'=>'celebration.png',
            ];
            $algoResult['celebration'] = hasPointOfFaithAndFuelBcaActivityLog($bcaLogs);
            $tempObj['result'] = $algoResult;

            array_push($data_set,$tempObj);
        }

        $loggedInDates = $this->getAllLoggedInDates($user_id);

        foreach ($loggedInDates as $date_key => $date_value) {
            $tempObj = [
                'date'=> $date_value['date'],
                "classNames"=>"text-center"
            ];
            $algoResult = [];
            $filename = 'Excellent.png';
            $algoResult = [
                'text'=>'Excellent',
                // 'image_url'=> Storage::disk('public')->get('static/Excellent.png')
                'image_url'=> config('app.url').'/storage/static/'.($filename)
                // 'image_url'=> storage_path('app/public/static/' .$filename)
            ];            
            $tempObj['result'] = $algoResult;

            array_push($data_set,$tempObj);
        }

        return $data_set;
    }


}