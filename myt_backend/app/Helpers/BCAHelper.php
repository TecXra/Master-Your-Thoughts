<?php
use App\Models\BCAAlgoChart;
use Illuminate\Support\Str;
use Facades\Services\BootCampAnalyticService;

if (!function_exists('isLevelA')) {
    function isLevelA($level_id)
    {
        return $level_id == 1;
    }
}

if (!function_exists('isLevelB')) {
    function isLevelB($level_id)
    {
        return $level_id == 2;
    }
}


if (!function_exists('noActivityAlgoId')) {
    function noActivityAlgoId()
    {
        return 4;
    }
}

if (!function_exists('hasPointOfFaithAndFuelBcaActivityLog')) {
    function hasPointOfFaithAndFuelBcaActivityLog($logs)
    {
        foreach ($logs as $key => $log) {
            
            if($log->bca_activity_id == getPointsOfFaithAndFuelBcaActivityId())
            {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('qualifyForBcaChartAlgo')) {
    function qualifyForBcaChartAlgo($logs)
    {

        $levelA_logs = [];
        $levelB_logs = [];
        foreach ($logs as $key => $log) {
            
            if(isLevelA($log->bcaActivity->level_id)){
                $levelA_logs[]=$log;
            }
            if(isLevelB($log->bcaActivity->level_id)){
                $levelB_logs[]=$log;
            }
        }
        
        $algo_id = noActivityAlgoId();
        if(count($levelA_logs)>=1 && count($levelB_logs)>=0){
            $algo_id = 1;
        }

        if(count($levelA_logs)==1 && count($levelB_logs)==0){
            $algo_id = 2;
        }

        if(count($levelA_logs)==0 && count($levelB_logs)>=1){
            $algo_id = 3;
        }

        if(count($levelA_logs)==0 && count($levelB_logs)==0){
            $algo_id = 4;
        }
        

        if(isset($algo_id)){
            $algo = BCAAlgoChart::find($algo_id);
        }
        return $algo;
    }
}



if (!function_exists('saveBootCampAnalyticLog')) {
    function saveBootCampAnalyticLog($user_id,$bca_activity_id)
    {
        return BootCampAnalyticService::saveBootCampAnalyticLog($user_id,$bca_activity_id);
    }
}



if (!function_exists('getLearnDashLecturesBcaActivityId')) {
    function getLearnDashLecturesBcaActivityId()
    {
        return 1;
    }
}


if (!function_exists('getLearnDashExercisesBcaActivityId')) {
    function getLearnDashExercisesBcaActivityId()
    {
        return 2;
    }
}

if (!function_exists('getDailyVideoReviewBcaActivityId')) {
    function getDailyVideoReviewBcaActivityId()
    {
        return 3;
    }
}

if (!function_exists('getPracticeCheckBcaActivityId')) {
    function getPracticeCheckBcaActivityId()
    {
        return 4;
    }
}

if (!function_exists('getPointsOfFaithAndFuelBcaActivityId')) {
    function getPointsOfFaithAndFuelBcaActivityId()
    {
        return 5;
    }
}

if (!function_exists('getMaxRelaxationBcaActivityId')) {
    function getMaxRelaxationBcaActivityId()
    {
        return 6;
    }
}

if (!function_exists('getBankingBcaActivityId')) {
    function getBankingBcaActivityId()
    {
        return 7;
    }
}

if (!function_exists('getVisionChartBcaActivityId')) {
    function getVisionChartBcaActivityId()
    {
        return 8;
    }
}

if (!function_exists('getTheHarmonizerBcaActivityId')) {
    function getTheHarmonizerBcaActivityId()
    {
        return 9;
    }
}

if (!function_exists('getTheVisualizerBcaActivityId')) {
    function getTheVisualizerBcaActivityId()
    {
        return 10;
    }
}

if (!function_exists('getTheAttractionWallBcaActivityId')) {
    function getTheAttractionWallBcaActivityId()
    {
        return 11;
    }
}
