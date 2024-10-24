<?php
use App\Models\Unit;
use App\Models\Question;
use App\Models\Response as QuestionResponse;
use App\Models\Answer;
use App\Models\Phrase;
use Carbon\Carbon;
use App\Models\MytResponse;
use App\Models\DraftWallpaper;
use App\Models\LoopingDuration;
use Facades\Services\WallpaperService;
use Illuminate\Support\Str;


if (!function_exists('getUnitById')) {
    function getUnitById($unit_id)
    {
        $unit = Unit::find($unit_id);
        return $unit;
    }
}

if (!function_exists('getQuestionById')) {
    function getQuestionById($question_id)
    {
        $question = Question::find($question_id);
        return $question;
    }
}


if (!function_exists('getFirstUnit')) {
    function getFirstUnit()
    {
        $unit = Unit::orderBy('number')->first();
        return $unit;
    }
}


if (!function_exists('getFirstQuestionOfUnit')) {
    function getFirstQuestionOfUnit($unit_id)
    {
        $question = Question::where('unit_id',$unit_id)->orderBy('number')->first();
        return $question;
    }
}





if (!function_exists('getUnitByNumber')) {
    function getUnitByNumber($number)
    {
        $unit = Unit::where('number',$number)->first();
        if(isset($unit)){
            return $unit; 
        }
        return null;
    }
}




if (!function_exists('getCompletedUnitsByUserId')) {
    function getCompletedUnitsByUserId($user_id)
    {
        $responses = QuestionResponse::where('user_id',$user_id)->get();
        $unitsList = [];
        if (count($responses) > 0) {
            foreach ($responses as $key => $response) {
                $unitsList[$response->question->unit_id][] = $response;
            }
        }

        $completedUnitsList = [];
        if (count($unitsList) > 0) {
            foreach ($unitsList as $key => $unit) {
                $unitObj = getUnitById($key);
                $unitQuestionIds = [];
                foreach ($unitObj->questions as $question) {
                    array_push($unitQuestionIds,$question->id);
                }

                $respondedUnitQuestionIds = [];
                foreach ($unit as $response) {
                    if($response->answer->tag->tag === 'upper'){
                        $respondedUnitQuestionIds[] = $response->question_id;
                    }
                }
                sort($unitQuestionIds);
                sort($respondedUnitQuestionIds);
                $respondedUnitQuestionIds = array_unique($respondedUnitQuestionIds);
                sort($respondedUnitQuestionIds);

                if($unitQuestionIds == $respondedUnitQuestionIds){
                    $completedUnitsList[] = $key;
                }
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



if (!function_exists('getPreviousUnitsListByUnitId')) {
    function getPreviousUnitsListByUnitId($unit_id)
    {
        $unit = getUnitById($unit_id);
        return Unit::where('number','<',$unit->number)->get();
    }
}

if (!function_exists('getNextUnitsListByUnitId')) {
    function getNextUnitsListByUnitId($unit_id)
    {
        $unit = getUnitById($unit_id);
        return Unit::where('number','>',$unit->number)->get();
    }
}


if (!function_exists('getNextUnitByUnitId')) {
    function getNextUnitByUnitId($unit_id)
    {
        $unit = getUnitById($unit_id);
        return Unit::where('number','>',$unit->number)->first();
    }
}


if (!function_exists('getNextQuestionOfUnitByQuesitonId')) {
    function getNextQuestionOfUnitByQuesitonId($unit_id,$question_id)
    {
        $question = getQuestionById($question_id);
        return Question::where('unit_id',$unit_id)->where('number','>',$question->number)->first();
    }
}




if (!function_exists('getUpComingUnitsByUserId')) {
    function getUpComingUnitsByUserId($user_id)
    {
        $inProgressUnit = getInProgressUnitByUserId($user_id);

        $dateSet = [];
        if(isset($inProgressUnit)){
            $unit = $inProgressUnit;
            $units = getNextUnitsListByUnitId($unit->id);
            if(count($units)>0){
                array_push($dateSet,$units[0]->id);            
                if(count($units)>1){
                    array_push($dateSet,$units[count($units)-1]->id);
                }
            }
        }        
        return $dateSet;
    }
}


if (!function_exists('getInProgressUnitByUserId')) {
    function getInProgressUnitByUserId($user_id)
    {
        $completedUnits = getCompletedUnitsByUserId($user_id);
        
        if(count($completedUnits)>0){
            $unit =  getNextUnitByUnitId($completedUnits[count($completedUnits)-1]);
        }else{
            $unit = getFirstUnit();
        }
        
        if(isset($unit)){
            return $unit;
        }
        return null;
    }
}


if (!function_exists('getInProgressUnitQuestionByUserId')) {
    function getInProgressUnitQuestionByUserId($user_id)
    {
        $completedUnits = getCompletedUnitsByUserId($user_id);
        if(count($completedUnits)>0){
            $unit =  getNextUnitByUnitId($completedUnits[count($completedUnits)-1]);
        }else{
            $unit = getFirstUnit();
        }

        if(isset($unit)){
            return getInProgressQuestionOfUnitByUserId($unit->id,$user_id);
        }
        return null;
    }
}


if (!function_exists('getInProgressQuestionOfUnitByUserId')) {
    function getInProgressQuestionOfUnitByUserId($unit_id,$user_id)
    {
        $unit = getUnitById($unit_id);
        $respondedQuestionIdsList = [];
        $unitQuestionsList = $unit->questions;
        $unitQuestionIdsList = [];
        foreach ($unitQuestionsList as $key => $question) {
            $unitQuestionIdsList[] = $question->id;
            $responses = QuestionResponse::where('user_id',$user_id)->where('question_id',$question->id)->get();
            foreach ($responses as $key => $response) {
                if($response->answer->tag->tag === 'upper'){
                    $respondedQuestionIdsList[] = $response->question_id;
                }
            }
        }
        sort($unitQuestionIdsList);
        sort($respondedQuestionIdsList);
        
        $notRespondedQuestionIds = array_values(array_diff($unitQuestionIdsList,$respondedQuestionIdsList));
        $notRespondedQuestionIds;
        
        
        if(count($notRespondedQuestionIds)>0){
            $nextQuestion = getQuestionById($notRespondedQuestionIds[0]); 
            if(isset($nextQuestion)){
                return $nextQuestion;
            }
        }else{
            return getFirstQuestionOfUnit($unit_id); 
        }

        return null;
    }
}







if (!function_exists('getLatestResponseByUserId')) {
    function getLatestResponseByUserId($user_id)
    {
        $response = QuestionResponse::where('user_id',$user_id)->latest()->first();
        $dataSet = [
            'unit'=>$response->question->unit,
            'question'=>$response->question,
            'phrase'=>$response->phrase,
            'answer'=>$response->answer,
        ];
        
        return $dataSet;
    }
}



if (!function_exists('getUnitQuestionResponse')) {
    function getUnitQuestionResponse($question_id,$phrase_id,$user_id)
    {
        $response = QuestionResponse::where('user_id',$user_id)->where('question_id',$question_id)->where('phrase_id',$phrase_id)->latest()->first();
        return $response;
    }
}



if (!function_exists('getUnitQuestionsListWithStatus')) {
    function getUnitQuestionsListWithStatus($unit_id,$user_id)
    {
        $unit = getUnitById($unit_id);
        $formatedQuesitonsList = [];

        $completedQuestionsList=[];
        $pendingQuestionsList=[];

        $questionsList = $unit->questions;
        foreach ($questionsList as $question) {
            $tempObj = [ 'id'=> $question->id, 'number'=> $question->number, 'type'=> $question->type];
            $questionResponse = 'pending';
            foreach ($question->phrases as $phrase) {
                $response = getUnitQuestionResponse($question->id,$phrase->id,$user_id);
                isUpperResponsesCompleted($question->id, $user_id);
                if(isset($response) && isUpperResponsesCompleted($question->id, $user_id) && $response->answer->tag->tag === 'upper'){
                    $questionResponse = 'completed';
                    break;
                }                
            }
            $tempObj['status'] = $questionResponse;
			
            if($questionResponse === 'completed'){
                array_push($completedQuestionsList,$tempObj);
            }
            if($questionResponse === 'pending'){
                array_push($pendingQuestionsList,$tempObj);
            }
		}

        $workingQuestionList = [];
        if(count($pendingQuestionsList)>0){
            $tempObj = $pendingQuestionsList[0];
            if($tempObj['status'] === 'pending' && isQuestionQualify($tempObj['id'],$user_id)){
                $tempObj['status'] = 'working';
                array_push($workingQuestionList,$tempObj);
                unset($pendingQuestionsList[0]);                
            }
        }

        $pendingQuestionsList = array_values($pendingQuestionsList);

        // foreach ($completedQuestionsList as $key => $question) {
        //     array_push($formatedQuesitonsList,$question);
        // }
        foreach ($workingQuestionList as $key => $question) {
            array_push($formatedQuesitonsList,$question);
        }
        foreach ($pendingQuestionsList as $key => $question) {
            array_push($formatedQuesitonsList,$question);
        }
        return $formatedQuesitonsList;
    }
}

if (!function_exists('isUpperResponsesCompleted')) {
    function isUpperResponsesCompleted($question_id,$user_id)
    {
        $question = Question::find($question_id);
        $unit_id = $question->unit_id;

        $totalUpperResponses =  MytResponse::where('type', 'PracticeCheck')->where('tag_id', 1)->where('unit_id', $unit_id)->get();

        $upperResponseIdsList = [];
        foreach ($totalUpperResponses as $key => $response) {
            $upperResponseIdsList[]=$response->id;
        }

        
        $givenResponse = QuestionResponse::where('user_id',$user_id)->where('question_id',$question_id)->get();

    

        $givenUpperResponsesIdsList = [];
        


        for ($i=0; $i < count($givenResponse); $i++)
        { 
            $answer = Answer::find($givenResponse[$i]->answer_id);
            if ($answer->tag_id == 1)
            {
                array_push($givenUpperResponsesIdsList, $givenResponse[$i]->myt_response_id);
            }
        }

        sort($upperResponseIdsList);
        sort($givenUpperResponsesIdsList);


        // if any upper response given ;  
        // break the loop for any uper response given        
        if(count($givenUpperResponsesIdsList)>0){
            return true;
        }else{
            return false;
        }


        // loop all phrases

        $notRespondedUpperResponsesIds = array_values(array_diff($upperResponseIdsList,$givenUpperResponsesIdsList));
        if(count($notRespondedUpperResponsesIds) > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}


if (!function_exists('isQuestionQualify')) {
    function isQuestionQualify($question_id,$user_id)
    {
        $response = QuestionResponse::where('user_id',$user_id)->where('question_id',$question_id)->latest()->first();
        
        if(!isset($response)){
            $response = QuestionResponse::where('user_id',$user_id)->latest()->first();
        }
        if(isset($response)){ 
            $responseDateTime = $response->created_at;
            $questionLoopDurationDateTime = Carbon::parse($response->created_at)->addMinutes(getQuestionLoopingDuration());
            if($questionLoopDurationDateTime < Carbon::now()){
                return true;
            }
        }else{
            return true;
        }
        return false;
    }
}


if (!function_exists('getQuestionLoopingDuration')) {
    function getQuestionLoopingDuration()
    {
        $looping_duration = LoopingDuration::where('type','PracticeCheck')->first();
        if(isset($looping_duration)){
            return (float)$looping_duration->duration;
        }
        return config('MYT.default_looping_duration');
    }
}



if (!function_exists('getUserQuestionResponse')) {
    function getUserQuestionResponse($user_id)
    {
        $response = QuestionResponse::where('user_id',$user_id)->get();
        if(count($response)>0){
            return true;
        }
        return false;
    }
}



if (!function_exists('getQuestionPhrase')) {
    function getQuestionPhrase($question_id,$user_id)
    {
        $question = getQuestionById($question_id);
        $questionPhraseIdsList = [];
        foreach ($question->phrases as $key => $phrase) {
            $questionPhraseIdsList[]=$phrase->id;
        }


        $respondedQuestions = QuestionResponse::where('question_id',$question_id)->where('user_id',$user_id)->get();
        $latestResponse = QuestionResponse::where('question_id',$question_id)->where('user_id',$user_id)->latest()->first();
        $respondedQuestionPhrasesIds = [];
        foreach ($respondedQuestions as $key => $response) {
            $respondedQuestionPhrasesIds[$response->phrase_id]=$response->phrase_id;
        }               
        $respondedQuestionPhrasesIdsList = array_values($respondedQuestionPhrasesIds);

        sort($questionPhraseIdsList);
        sort($respondedQuestionPhrasesIdsList);
        
        $notRespondedQuestionPhraseIds = array_values(array_diff($questionPhraseIdsList,$respondedQuestionPhrasesIdsList));

        if(count($notRespondedQuestionPhraseIds) > 0){
            $phrase_id = $notRespondedQuestionPhraseIds[0];
        }else{
            
            $index = array_search($latestResponse->phrase_id, $questionPhraseIdsList);
            if($index !== false && $index < count($questionPhraseIdsList)-1) {
                $phrase_id = $questionPhraseIdsList[$index+1];
            }
            else {
                
                $phrase_id = $questionPhraseIdsList[0];
            }
        }
        


        return Phrase::find($phrase_id);
    }
}





if (!function_exists('getReportByType')) {
    function getReportByType($type)
    {
        foreach (config('MYT.report_types') as $key => $value) {
            if($value['key'] == $type){
                return $value['report'];
            }
        }
        return null;
    }
}



if (!function_exists('getMytResponseForQuestionResponse')) {
    function getMytResponseForQuestionResponse($response)
    {
        
        $myt_responses = MytResponse::where('tag_id',$response->answer->tag_id)->where('unit_id',$response->question->unit_id)->where('type','PracticeCheck')->get();
        $lastResponses = QuestionResponse::where('id','<>',$response->id)->where('user_id',$response->user_id)->latest()->get();
        
        $lastResponsesByTag=[];
        foreach ($lastResponses as $key => $l_res) {
            if($l_res->answer->tag_id == $response->answer->tag_id){
                array_push($lastResponsesByTag,$l_res);
            }
        }


        $lastResponseByTagByUnit = null;
        foreach ($lastResponsesByTag as $key => $lr_tag) {
            if($lr_tag->question->unit_id == $response->question->unit_id){
                $lastResponseByTagByUnit = $lr_tag;
                break;
            }
        }
        
        if(count($myt_responses) > 0){
            if(isset($lastResponseByTagByUnit) && isset($lastResponseByTagByUnit->myt_response_id)){
                $myt_response = getNextMytResponse($lastResponseByTagByUnit->myt_response_id);
            }else{
                $myt_response = $myt_responses[0];
            }
        }else{
            $myt_response = null;
        }

        return $myt_response;
    }
}

if (!function_exists('isCurrentUnitStarted')) {
    function isCurrentUnitStarted($unit_id, $user_id)
    {
        // $question = Question::where('unit_id',$unit_id)->get();
        // question_id
        $question = getFirstQuestionOfUnit($unit_id);
        if (isset($question))
        {
            $responses = QuestionResponse::where('user_id',$user_id)->where('question_id',$question->id)->get();
            // QuestionResponse::
            if (count($responses) > 0) {
                return true;
            }
            return false;
        }
        return false;
    }
}

if (!function_exists('showInProgressUnitText')) {
    function showInProgressUnitText($unit_number)
    {
        switch ($unit_number) {
            case 1:
                return 'Start Here After Unit 1.6';
                break;
            case 2:
                return 'Return Here After Unit 2.4';
                break;
            case 3:
                return 'Return Here After Unit 3.4';
                break;
            case 4:
                return 'Return Here After Unit 4.4';
                break;
            case 5:
                return 'Return Here After Unit 5.3';
                break;
            case 6:
                return 'Return Here After Unit 6.5';
                break;
            case 7:
                return 'Return Here After Unit 7.4';
                break;       
            default:
                return 'In-Progress Question';
                break;
        }
    }
}


if (!function_exists('getMytResponseById')) {
    function getMytResponseById($id)
    {
        $myt_response = MytResponse::find($id);
        if(isset($myt_response)){
            return $myt_response;
        }    
        return null;
    }
}



if (!function_exists('getNextMytResponse')) {
    function getNextMytResponse($myt_response_id)
    {
        $mytResponse = MytResponse::find($myt_response_id);
        $mytResponses = MytResponse::where('tag_id',$mytResponse->tag_id)->where('unit_id',$mytResponse->unit_id)->where('type',$mytResponse->type)->orderBy('id')->get();

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

if (!function_exists('saveNewUserWallpaperToDraft')) {
    function saveNewUserWallpaperToDraft($user_id)
    {
        $saveDefaultWallpaperObj = null;
        $deviceList = [ "desktop", "iphone", "ipad"];

        $tW = 400;
        $tH = 250;
        $textWidth = 310;
        $textHeight = 50;

        $jsonData = [
            "backgroundInfo" => [
                "image" => null,
                "color" => '#ffffff'
            ],
            "foregroundInfo" => [
                "image" => null,
                "width" => $tW,
                "height" => $tH,
                "left" => 'calc(50% - ( ' . $tW . ' / 2)px)',
                "top" => 'calc(50% - ( ' . $tH . ' / 2)px)'
            ],
            "textInfo" => [
                "content" => '<p>Here is where you can add your text.</p>',
                "color" => '#a6a6a6',
                "fontFamily" => 'Poppins',
                "width" => $textWidth,
                "height" => $textHeight,
                "left" => 0,
                "top" => 0
            ]
        ];
        for ($i=0; $i < count($deviceList); $i++) { 
            $payload = [
                "device_type" => $deviceList[$i],
                "draftData" => $jsonData
            ];

            $draftedWallpaperObj = DraftWallpaper::where('user_id',$user_id)->where('device_type',$deviceList[$i])->first();
            if (!isset($draftedWallpaperObj)) {
                $saveDefaultWallpaperObj = WallpaperService::saveWallpaperToDraft($payload, $user_id);
            }
        }
        return $saveDefaultWallpaperObj;
    }
}

