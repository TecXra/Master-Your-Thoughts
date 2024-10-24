<?php
use App\Models\Unit;
use App\Models\VRQuestion;
use App\Models\VRResponse;
use App\Models\VRPhrase;

use App\Models\LoopingDuration;
use Carbon\Carbon;
use App\Models\MytResponse;
use Illuminate\Support\Str;

if (!function_exists('getInProgressUnitVideoQuestionByUserId')) {
    function getInProgressUnitVideoQuestionByUserId($user_id)
    {
        // unit 1-7 videos
        $inProgressUnit = getInProgressUnitByUserId($user_id);

        $videos_enabled_unit = config('MYT.videos_enabled_unit');
        $qualifiedVideosIDsList = getInProgressUnitQualifiedVidoes($inProgressUnit);
        $previousResponseVideosIDsList = getAllVideoResponsesQuestionIDsByUserId($user_id);

        if (isset($inProgressUnit))
        {

            if ($inProgressUnit->number >= $videos_enabled_unit)
            {
                if (count($previousResponseVideosIDsList) > 0)
                {
                    $lastResponse = getVideoLatestResponseByUserId($user_id);
                    $notRespondedQuestionIds = array_values(array_diff($qualifiedVideosIDsList,$previousResponseVideosIDsList));
                    $lastResponseTime = $lastResponse->created_at;
                    $videoDurationDateTime = Carbon::parse($lastResponseTime)->addMinutes(getVideoQuestionDuration());
                    if($videoDurationDateTime < Carbon::now())
                    {
                        if (count($notRespondedQuestionIds) > 0)
                        {
                            return getVideoQuestionById($notRespondedQuestionIds[0]);
                        }
                        else
                        {
                            // [ 4, 5, 7, 8, 2, 6, 3, 1 ]

                            $index = array_search($lastResponse->v_r_question_id, $qualifiedVideosIDsList);
                            if($index !== false && $index > 0 ) {
                                $prev = $qualifiedVideosIDsList[$index-1];
                            }

                            if($index !== false && $index < count($qualifiedVideosIDsList)-1) {
                                $next = $qualifiedVideosIDsList[$index+1];

                                return getVideoQuestionById($next);
                            }
                            else {

                                return getVideoQuestionById($qualifiedVideosIDsList[0]);
                            }
                        }
                    }
                }
                else
                {
                    if (count($qualifiedVideosIDsList) > 0)
                    {
                        return getVideoQuestionById($qualifiedVideosIDsList[0]);
                    }
                    else
                    {
                        return 'No video added yet.';
                    }
                }
            }
        }
        else
        {
            $lastResponse = getVideoLatestResponseByUserId($user_id);
            $index = 0;
            if (isset($lastResponse)) {
                $index = array_search($lastResponse->v_r_question_id, $qualifiedVideosIDsList);
            }
            if($index !== false && $index > 0 ) {
                $prev = $qualifiedVideosIDsList[$index-1];
            }

            if($index !== false && $index < count($qualifiedVideosIDsList)-1) {
                $next = $qualifiedVideosIDsList[$index+1];

                return getVideoQuestionById($next);
            }
            else {

                return getVideoQuestionById($qualifiedVideosIDsList[0]);
            }
        }
        return null;
    }
}


if (!function_exists('getCompletedVideoUnitsByUserId')) {
    function getCompletedVideoUnitsByUserId($user_id)
    {
        $responses = VRResponse::where('user_id',$user_id)->get();
        $unitsList = [];
        foreach ($responses as $key => $response) {
            $unitsList[$response->vRQuestion->unit_id][] = $response;
        }

        $completedUnitsList = [];
        foreach ($unitsList as $key => $unit) {
            $unitObj = getVideoUnitById($key);
            $unitQuestionIds = [];
            foreach ($unitObj->vRQuestions as $question) {
                array_push($unitQuestionIds,$question->id);
            }

            $respondedUnitQuestionIds = [];
            foreach ($unit as $response) {
                if($response->vRAnswer->tag->tag === 'upper') {
                    $respondedUnitQuestionIds[] = $response->question_id;
                }
            }
            // sort($unitQuestionIds);
            // return $unitQuestionIds;
            $respondedUnitQuestionIds;
            sort($respondedUnitQuestionIds);
            if($unitQuestionIds == $respondedUnitQuestionIds){
                $completedUnitsList[] = $key;
            }
        }
        $dateSet = [];
        if(count($completedUnitsList)>0){
            array_push($dateSet,$completedUnitsList[0]);
            if(count($completedUnitsList)>1){
                array_push($dateSet,$completedUnitsList[count($completedUnitsList)-1]);
            }
        }

        return $dateSet;

    }
}

if (!function_exists('getNextVideoQuestion')) {
    function getNextVideoQuestion($nextUnit, $user_id)
    {
        // $inProgressUnit = getInProgressUnitByUserId($user_id);
        // $nextUnit = getNextVideoUnitByUnitId($unit_id);
        // $unit = getVideoUnitById($nextUnit->id);
        $viewedVideosQuestionIdsList = [];
        $unitQuestionsList = $nextUnit->vRQuestions;
        if (count($unitQuestionsList) > 0)
        {
            $unitQuestionIdsList = [];
            foreach ($unitQuestionsList as $key => $question) {
                $unitQuestionIdsList[] = $question->id;
                $responses = VRResponse::where('user_id',$user_id)->where('v_r_question_id',$question->id)->get();

                foreach ($responses as $key => $response)
                {
                    $viewedVideosQuestionIdsList[] = $response->v_r_question_id;
                }
            }
            // sort($unitQuestionIdsList);
            // sort($viewedVideosQuestionIdsList);
            $notRespondedQuestionIds = array_values(array_diff($unitQuestionIdsList,$viewedVideosQuestionIdsList));

            if(count($notRespondedQuestionIds)>0)
            {
                $nextQuestion = getVideoQuestionById($notRespondedQuestionIds[0]);

                if(isset($nextQuestion))
                {
                    return $nextQuestion;
                }
            }
            else
            {
                return getFirstVideoQuestionOfUnit($nextUnit->id);
            }
        }
        return null;
    }
}
if (!function_exists('getVideoQuestionPhrase')) {
    function getVideoQuestionPhrase($question_id,$user_id)
    {
        $question = getVideoQuestionById($question_id);
        $questionPhraseIdsList = [];
        foreach ($question->vRPhrase as $key => $phrase) {
            $questionPhraseIdsList[] = $phrase->id;
        }


        $respondedQuestions = VRResponse::where('v_r_question_id',$question_id)->where('user_id',$user_id)->get();
        $latestResponse = VRResponse::where('v_r_question_id',$question_id)->where('user_id',$user_id)->latest()->first();
        $respondedQuestionPhrasesIds = [];
        foreach ($respondedQuestions as $key => $response) {
            $respondedQuestionPhrasesIds[$response->v_r_phrase_id]=$response->v_r_phrase_id;
        }
        $respondedQuestionPhrasesIdsList = array_values($respondedQuestionPhrasesIds);

        sort($questionPhraseIdsList);
        sort($respondedQuestionPhrasesIdsList);

        $notRespondedQuestionPhraseIds = array_values(array_diff($questionPhraseIdsList,$respondedQuestionPhrasesIdsList));

        // $v_r_phrase_id = $questionPhraseIdsList[0];

        if(count($notRespondedQuestionPhraseIds) > 0){
            $v_r_phrase_id = $notRespondedQuestionPhraseIds[0];
        }else{

            $index = array_search($latestResponse->v_r_phrase_id, $questionPhraseIdsList);
            if($index !== false && $index < count($questionPhraseIdsList)-1) {
                $v_r_phrase_id = $questionPhraseIdsList[$index+1];
            }
            else {

                $v_r_phrase_id = $questionPhraseIdsList[0];
            }
        }


        return VRPhrase::find($v_r_phrase_id);
    }
}

if (!function_exists('getInProgressUnitQualifiedVidoes')) {
    function getInProgressUnitQualifiedVidoes($inProgressUnit)
    {
        if (isset($inProgressUnit))
        {
            $inProgressUnitNumber = $inProgressUnit->number;
        }
        else
        {
            $inProgressUnitNumber = config('MYT.last_unit_number');
        }
        $previousUnitsVideosList = VRQuestion::where('enable_on_unit', '<=' ,$inProgressUnitNumber)->get()->groupBy('unit_number');

        $maxQuestionLength = 0;

        $questionsList = [];
        $unitArray = [];
        $questionArray = [];

        foreach ($previousUnitsVideosList as $key => $unitQuestionList) {
            if($maxQuestionLength < count($unitQuestionList)){
                $maxQuestionLength = count($unitQuestionList);
            }
        }

        for ($index=0; $index < $maxQuestionLength; $index++) {
            foreach ($previousUnitsVideosList as $key => $unitQuestionList) {
                $collection = collect($unitQuestionList);
                $sortedList = $collection->sortBy('number');
                $sortedList = array_values($sortedList->toArray());
                if(count($sortedList) > $index){
                    $questionsList[] = $sortedList[$index]['id'];
                    // $questionsList[] = $sortedList[$index]['unit_number'] .'.'. $sortedList[$index]['number'];
                }
            }
        }

        return $questionsList;
    }
}


if (!function_exists('getMytVideoResponseForQuestionResponse')) {
    function getMytVideoResponseForQuestionResponse($response)
    {
        $myt_responses = MytResponse::where('tag_id',$response->vRAnswer->tag_id)->where('type','VideoReview')->get();

        $lastResponses = VRResponse::where('id','<>',$response->id)->where('user_id',$response->user_id)->latest()->get();

        $lastResponsesByTag=[];
        foreach ($lastResponses as $key => $l_res) {
            if($l_res->vRAnswer->tag_id == $response->vRAnswer->tag_id){
                array_push($lastResponsesByTag,$l_res);
            }
        }

        $lastResponsesByTagSortedByUpdatedAt = collect($lastResponsesByTag)->sortByDesc('updated_at')->first();


        if(count($myt_responses) > 0){
            if($lastResponsesByTagSortedByUpdatedAt  && $lastResponsesByTagSortedByUpdatedAt->myt_response_id){
                $myt_response = getNextMytVideoResponse($lastResponsesByTagSortedByUpdatedAt->myt_response_id);
            }else{
                $myt_response = $myt_responses[0];
            }
        }else{
            $myt_response = null;
        }


        return $myt_response;
    }
}

if (!function_exists('getNextMytVideoResponse')) {
    function getNextMytVideoResponse($myt_response_id)
    {

        $mytResponse = MytResponse::find($myt_response_id);
        $mytResponses = MytResponse::where('tag_id',$mytResponse->tag_id)->where('type',$mytResponse->type)->orderBy('id')->get();

        if(count($mytResponses)>0){
            foreach ($mytResponses as $key => $response) {
                if($response->id == $mytResponse->id){
                    $tempCurrentResIndex = $key+1;
                    break;
                }
            }

            if($tempCurrentResIndex>count($mytResponses)-1){
                $tempCurrentResIndex = 0;
            }
            return $mytResponses[$tempCurrentResIndex];
        }


        if(count($mytResponses)==1){
            return $mytResponses[0];
        }

        return null;
    }
}


if (!function_exists('getLastResponseVideoQuestionByUserId')) {
    function getLastResponseVideoQuestionByUserId($user_id)
    {
        $lastResponse = getVideoLatestResponseByUserId($user_id);
        if (isset($lastResponse))
        {
            return getVideoQuestionById($lastResponse->v_r_question_id);
        }
        return null;

    }
}


if (!function_exists('getUserVideoQuestionResponse')) {
    function getUserVideoQuestionResponse($user_id)
    {
        $response = VRResponse::where('user_id',$user_id)->get();
        if(count($response)>0){
            return true;
        }
        return false;
    }
}

if (!function_exists('getFirstUnitAfterLoop')) {
    function getFirstUnitAfterLoop($unit)
    {
        return Unit::where('number','<',$unit->number)->first();
        // return Unit::where('number','>',$unit->number)->first();
    }
}

if (!function_exists('getAllVideoResponsesQuestionIDsByUserId')) {
    function getAllVideoResponsesQuestionIDsByUserId($user_id)
    {
        $previousResponsesList = VRResponse::where('user_id',$user_id)->get();
        $previousResponsesIDsList= [];

        foreach ($previousResponsesList as $response) {
            $previousResponsesIDsList[] = $response->v_r_question_id;
        }

        return $previousResponsesIDsList;
    }
}

if (!function_exists('getVideoLatestResponseByUserId')) {
    function getVideoLatestResponseByUserId($user_id)
    {
        return VRResponse::where('user_id',$user_id)->latest()->first();
    }
}

if (!function_exists('getVideoQuestionDuration')) {
    function getVideoQuestionDuration()
    {
        $looping_duration = LoopingDuration::where('type','VideoReview')->first();
        if(isset($looping_duration)){
            return (float)$looping_duration->duration;
        }
        return config('MYT.default_looping_duration');

    }
}

if (!function_exists('getVideoUnitById')) {
    function getVideoUnitById($unit_id)
    {
        $unit = Unit::find($unit_id);
        return $unit;
    }
}

if (!function_exists('getNextVideoUnitByUnitId')) {
    function getNextVideoUnitByUnitId($unit_id)
    {
        $unit = getVideoUnitById($unit_id);
        return Unit::where('number','>',$unit->number)->first();
    }
}

if (!function_exists('getFirstVideoUnit')) {
    function getFirstVideoUnit()
    {
        $unit = Unit::orderBy('number')->first();
        return $unit;
    }
}

if (!function_exists('getVideoQuestionById')) {
    function getVideoQuestionById($question_id)
    {
        $question = VRQuestion::find($question_id);
        return $question;
    }
}

if (!function_exists('getFirstVideoQuestionOfUnit')) {
    function getFirstVideoQuestionOfUnit($unit_id)
    {
        $question = VRQuestion::where('unit_id',$unit_id)->orderBy('number')->first();
        return $question;
    }
}
