<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Facades\Services\UnitService;
use App\Models\Response as QuestionResponse;

use Facades\Services\UserService;
use Facades\Services\VideoReviewService;
use Facades\Services\BootCampAnalyticService;
use Facades\Services\BankingService;


class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $data_array=[
            'account_id'=>3,
            'per_page'=>2,
            'page'=>2,        
        ];
        dd(BankingService::getTransactionsList($data_array));


        dd(UserService::getMytUserIdByWPUserId(1));
        dd(BootCampAnalyticService::getAllBootCampAnalyticsLog(2));

        $user_id = 1;

        dd(saveBootCampAnalyticLog($user_id,getLearnDashLecturesBcaActivityId()));
        dd(saveBootCampAnalyticLog($user_id,getLearnDashExercisesBcaActivityId()));
        dd(saveBootCampAnalyticLog($user_id,getDailyVideoReviewBcaActivityId()));
        dd(saveBootCampAnalyticLog($user_id,getPracticeCheckBcaActivityId()));
        dd(saveBootCampAnalyticLog($user_id,getPointsOfFaithAndFuelBcaActivityId()));
        dd(saveBootCampAnalyticLog($user_id,getMaxRelaxationBcaActivityId()));
        dd(saveBootCampAnalyticLog($user_id,getBankingBcaActivityId()));
        dd(saveBootCampAnalyticLog($user_id,getVisionChartBcaActivityId()));
        dd(saveBootCampAnalyticLog($user_id,getTheHarmonizerBcaActivityId()));
        dd(saveBootCampAnalyticLog($user_id,getTheVisualizerBcaActivityId()));



        dd(BootCampAnalyticService::getWeeklyBootCampAnalyticsLog(2,"11/24/2021"));




        $data_array=[
            'user_id'=>1,
            'bca_activity_id'=>1,            
        ];

        dd(BootCampAnalyticService::saveBootCampAnalyticLog($data_array));






        $data_array=[
            'phrase_id'=>1,
            'question_id'=>10,
        ];

        dd(UnitService::getUnitQuestionAnswerResponse($data_array,4));




        $data_array=[
            'phrase_id'=>1,
            'question_id'=>1,
        ];

        dd(VideoReviewService::getUnitVideoQuestionAnswerResponse($data_array,3));




        dd(getVideoQuestionDuration());
        dd(getQuestionLoopingDuration());
        dd(UserService::resetUserData(2));
        $phrase = getQuestionPhrase(1,2);
        dd($phrase->phrase);


        $data_array=[
            'phrase_id'=>1,
            'question_id'=>9,
        ];

        dd(UnitService::getUnitQuestionAnswerResponse($data_array,3));



        $responses = QuestionResponse::where('question_id',1)->where('user_id',2)->get();
        
		$response = null;
		if(count($responses)>0){
			$response = $responses[count($responses)-1];
		}

        dd($response);

        dd(getMytResponseForQuestionResponse($response));

        dd(UnitService::getTimerDeadLine(2,'PracticeCheck'));
        dd(UnitService::getTimerDeadLine(2,'VideoReview'));

        dd(UserService::{getReportByType(1)}());

        dd(UserService::getUnitThatIsCurrentlyBeingWorked());
        dd(UserService::getDateTheUnitThatIsCurrentlyBeingWorkedStarted());
        

        // dd(getFirstUnitId());

        // dd(getCompletedUnitsNumberByUserId(2));

        // dd(UnitService::getUserUnitStats(2));

        // $response = QuestionResponse::find(1);

        // dd($response->answer->tag->tag);



        // $response = UnitService::getUserUnitQuestionDetailById(1,1);
        $response = UnitService::getUserUnitQuestionDetailById(2,2);
        
        dd($response);

    }
}
