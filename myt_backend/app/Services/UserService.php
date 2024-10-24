<?php

namespace Services;

use Carbon\Carbon;
use App\Models\UserSetting;
use App\Models\TimeZone;
use App\Models\User;
use App\Models\Response as QuestionResponse;
use Illuminate\Support\Str;

use Facades\Services\UnitService;

use App\Models\VRQuestion;

class UserService
{
	public function saveUserInitialData($data_array,$auth_user_id)
	{
		$time_zone_id = $data_array['time_zone']['id'];
		// if(!isset($data_array['country']) && !isset($data_array['city']) && !isset($data_array['state']) && !isset($data_array['time_zone']) ){
		// 	return false;
		// }
		$user = User::find($auth_user_id);
		$user->userSetting()->update([
			// 'country'=>$data_array['country'],
			// 'city'=>$data_array['city'],
			// 'state'=>$data_array['state'],
			'time_zone'=>$time_zone_id,
		]);
		return true;
	}
	
	public function isAuthUserTimeZoneSettingExist($auth_user_id)
	{
		$user = User::find($auth_user_id);
		return $user->isTimeZoneSettingExist();
	}

	public function getUserTimeZone($auth_user_id)
	{
		$userSettingObj = UserSetting::where('user_id', $auth_user_id)->first();
		$timeZoneObj = TimeZone::find($userSettingObj->time_zone);
		return $timeZoneObj;
	}









	/////////////////////////////////// Admin ////////////////////////////////////////////////////




	public function getDateTheUserStartedTheFirstUnitStats()
	{

		$data_set=[];
		$columns = config('MYT.base_columns_for_report_stats');
		$columns[] = 'date';
		$data_set[] = $columns;
		$users = User::where('user_type','<>',config('MYT.user_type.admin'))->get();
		foreach ($users as $user) {
			$tempObj = [];
			$tempObj[] = $user->id;
			$tempObj[] = $user->name;
			$tempObj[] = $user->email;
			$tempObj[] = $user->state;
			$tempObj[] = $user->country;
			$firstUnitStatDateTime = 'N/A';
			foreach ($user->responses as $response) {
				$firstUnit = $response->question->unit()->where('number',1)->first();
				if(isset($firstUnit)){
					$firstUnitStatDateTime = $response->created_at->toDateTimeString();
					break;
				}
			}
			$tempObj[] = $firstUnitStatDateTime;
			$data_set[]=$tempObj;
		}	
		return $data_set;
	}


	public function getNumberOfPointsOfFaithAndFuelStats()
	{
		$data_set=[];
		$columns = config('MYT.base_columns_for_report_stats');
		$columns[] = 'faith & fuel points';
		$data_set[] = $columns;
		$users = User::where('user_type','<>',config('MYT.user_type.admin'))->get();
		foreach ($users as $user) {
			$tempObj = [];
			$tempObj[] = $user->id;
			$tempObj[] = $user->name;
			$tempObj[] = $user->email;
			$tempObj[] = $user->state;
			$tempObj[] = $user->country;
			$tempObj[] = $user->faithFuelPoints;
			$data_set[]=$tempObj;
		}	
		return $data_set;
	}

	public function getUnitThatIsCurrentlyBeingWorked()
	{
		$data_set=[];
		$columns = config('MYT.base_columns_for_report_stats');
		$columns[] = 'unit';
		$data_set[] = $columns;
		$users = User::where('user_type','<>',config('MYT.user_type.admin'))->get();
		foreach ($users as $user) {
			$tempObj = [];
			$tempObj[] = $user->id;
			$tempObj[] = $user->name;
			$tempObj[] = $user->email;
			$tempObj[] = $user->state;
			$tempObj[] = $user->country;
			$unit = getInProgressUnitByUserId($user->id)->number;
			$tempObj[] = $unit;
			$data_set[]=$tempObj;
		}	
		return $data_set;
	}

	public function getDateTheUnitThatIsCurrentlyBeingWorkedStarted()
	{
		$data_set=[];
		$columns = config('MYT.base_columns_for_report_stats');
		$columns[] = 'date';
		$data_set[] = $columns;
		$users = User::where('user_type','<>',config('MYT.user_type.admin'))->get();
		foreach ($users as $user) {
			$tempObj = [];
			$tempObj[] = $user->id;
			$tempObj[] = $user->name;
			$tempObj[] = $user->email;
			$tempObj[] = $user->state;
			$tempObj[] = $user->country;
			$currentUnitStartedDateTime = 'N/A';
       	 	$response = QuestionResponse::where('user_id',$user->id)->latest()->first();
			if(isset($response)){
				$currentUnitStartedDateTime = $response->created_at->toDateTimeString();
			}
			$tempObj[] = $currentUnitStartedDateTime;
			$data_set[]=$tempObj;
		}	
		return $data_set;
	}





	public function getUserDetails($user_id)
	{
		$user = User::find($user_id);
		
		$personalInfo = [
			'id' => $user->id,
			'time_zone' => $user->time_zone_name,
			'name' => $user->name,
			'email' => $user->email
		];
		$faithAndFuelPoints = $user->faithFuelPoints;
		$practiceCheckQuestions = UnitService::getUserUnitStats($user_id);
		$videoReviewQuesionIds = getAllVideoResponsesQuestionIDsByUserId($user_id);
		
		$videoReviewQuestions= VRQuestion::whereIn('id',$videoReviewQuesionIds)->get();
		$completedVideos = [];
		
		foreach ($videoReviewQuestions as $key => $vQuestion) {
			$temp =[
				'id'=>$vQuestion->id,
				'video_url'=>$vQuestion->video_url,
				'video_thumbnail_url'=>$vQuestion->video_thumbnail_url,
				'unit_number'=>$vQuestion->unit_id,
				'unit_id'=>$vQuestion->unit_id,
				'video_number'=>$vQuestion->unit_id .'.'. $vQuestion->number,
				'number'=>$vQuestion->number,
			];
			array_push($completedVideos,$temp);
		}
		$data_set=[
			'personalInfo'=> $personalInfo,
			'faithAndFuelPoints'=> $faithAndFuelPoints,
			'practiceCheckQuestions'=> $practiceCheckQuestions,
		];

		$nextVQuestion = getInProgressUnitVideoQuestionByUserId($user_id);
		if (isset($nextVQuestion)) {
			$nextVideo = [
				'id'=>$nextVQuestion->id,
				'video_url'=>$nextVQuestion->video_url,
				'video_thumbnail_url'=>$nextVQuestion->video_thumbnail_url,
				'unit_number'=>$nextVQuestion->unit_id,
				'unit_id'=>$nextVQuestion->unit_id,
				'video_number'=>$nextVQuestion->unit_id .'.'. $nextVQuestion->number,
				'number'=>$nextVQuestion->number,
			];
			$videoReviews =[
				'completed' =>$completedVideos,
				'next' =>$nextVideo, 
			];
			

			$data_set['videoReviews'] = $videoReviews;
		}

		return  $data_set;
	}



	public function resetUserData($user_id)
	{
		$user = User::find($user_id);
		$user->responses()->delete();
		$user->vrResponses()->delete();
		return 1;
	}

	public function getMytUserIdByWPUserId($wp_user_id)
	{
		$user = User::where('wp_user_id', $wp_user_id)->first();
		return $user->id;
	}


}