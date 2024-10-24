<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$baseControllerNameSpace = '\App\Http\Controllers\\';
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getUserDefaultThemeSettings', $baseControllerNameSpace.'Api\CommonController@getUserDefaultThemeSettings');
Route::post('/updateUserThemeSetting', $baseControllerNameSpace.'Api\CommonController@updateUserThemeSetting');
Route::get('/getAllTimeZonesList', $baseControllerNameSpace.'Api\CommonController@getAllTimeZonesList');

Route::get('/getStatesList', $baseControllerNameSpace.'Api\CommonController@getStatesList');


Route::post('user/uploadSlideShowImage', $baseControllerNameSpace.'User\SlideShowController@uploadSlideShowImage');
Route::get('user/getAuthUserSlideShowImages', $baseControllerNameSpace.'User\SlideShowController@getAuthUserSlideShowImages');
Route::get('user/deleteSlideShowImage/{media_id}', $baseControllerNameSpace.'User\SlideShowController@deleteSlideShowImage');
Route::get('user/updateSlideShowDefaultView', $baseControllerNameSpace.'User\SlideShowController@updateSlideShowDefaultView');
Route::get('user/updateSlideShowInterval', $baseControllerNameSpace.'User\SlideShowController@updateSlideShowInterval');
Route::get('user/getAuthUserSlideShowSettings', $baseControllerNameSpace.'User\SlideShowController@getAuthUserSlideShowSettings');




Route::post('user/saveHarmonizerActivityLog', $baseControllerNameSpace.'User\BootCampCalendarController@saveHarmonizerActivityLog');
Route::get('user/getWeeklyBootCampAnalyticsLog', $baseControllerNameSpace.'User\BootCampCalendarController@getWeeklyBootCampAnalyticsLog');

Route::get('user/getAllBootCampAnalyticsLog', $baseControllerNameSpace.'User\BootCampCalendarController@getAllBootCampAnalyticsLog');
Route::get('user/getMytUserIdByWPUserId/{wp_user_id}', $baseControllerNameSpace.'User\UserController@getMytUserIdByWPUserId');

Route::get('user/saveLearnDashLessonLog/{wp_user_id}', $baseControllerNameSpace.'User\LearnDashLogController@saveLearnDashLessonLog');
Route::get('user/saveLearnDashQuizLog/{wp_user_id}', $baseControllerNameSpace.'User\LearnDashLogController@saveLearnDashQuizLog');

Route::get('user/saveLearnDashLoggedInLog/{wp_user_id}', $baseControllerNameSpace.'User\LearnDashLogController@saveLearnDashLoggedInLog');


Route::prefix('auth')->group(function () use ($baseControllerNameSpace) {
    Route::get('/login/wp/{provider}', $baseControllerNameSpace.'Api\Auth\SocialLoginController@redirectToWordPressProvider');
    Route::get('/login/wp/{provider}/callback', $baseControllerNameSpace.'Api\Auth\SocialLoginController@handleWordPressProviderCallback');
    Route::get('/logout', $baseControllerNameSpace.'Api\Auth\AuthController@logout');

    Route::post('/login', $baseControllerNameSpace.'Api\Auth\LoginController@login');
});


Route::middleware(['auth:api'])->prefix('user')->group(function () use ($baseControllerNameSpace){
    Route::get('/authUserData', $baseControllerNameSpace.'User\UserController@getAuthUserData');
    Route::get('/isAuthUserTimeZoneSettingExist', $baseControllerNameSpace.'User\UserController@isAuthUserTimeZoneSettingExist');
    Route::post('/saveUserInitialData', $baseControllerNameSpace.'User\UserController@saveUserInitialData');
    Route::get('/getUserTimeZone', $baseControllerNameSpace.'User\UserController@getUserTimeZone');


    Route::get('/getTimerDeadLine', $baseControllerNameSpace.'User\UnitController@getTimerDeadLine');


    Route::get('/getUserUnitStats', $baseControllerNameSpace.'User\UnitController@getUserUnitStats');

    Route::get('/getInProgressUnitByUserId', $baseControllerNameSpace.'User\UnitController@getInProgressUnitByUserId');

    Route::get('/getUserUnitInitialDetail', $baseControllerNameSpace.'User\UnitController@getUserUnitInitialDetail');

    Route::get('/getUserPracticeStatus', $baseControllerNameSpace.'User\UnitController@getUserPracticeStatus');

    Route::get('/getUserUnitsList', $baseControllerNameSpace.'User\UnitController@getUserUnitsList');
    Route::get('/getUserUnitDetailById/{unitId}', $baseControllerNameSpace.'User\UnitController@getUserUnitDetailById');
    Route::get('/getUserUnitQuestionDetailById/{questionId}', $baseControllerNameSpace.'User\UnitController@getUserUnitQuestionDetailById');

    Route::post('/submitUnitQuestionAnswer', $baseControllerNameSpace.'User\UnitController@submitUnitQuestionAnswer');


    Route::get('/getUnitQuestionAnswerResponse', $baseControllerNameSpace.'User\UnitController@getUnitQuestionAnswerResponse');

    Route::get('/getVRUnitDetail/{id}',$baseControllerNameSpace.'User\UnitController@getVRUnitDetail');


});

/*-----------------------------api for random quote ---------------------------------*/

Route::get('user/getRandomQuote', $baseControllerNameSpace.'User\DashboardController@getRandomQuote');
Route::get('user/getQuotesLog', $baseControllerNameSpace.'User\DashboardController@getQuotesLog');

Route::get('user/getInstructionVideo', $baseControllerNameSpace.'User\WallpaperController@getInstructionVideo');
Route::post('user/saveWallpaper', $baseControllerNameSpace.'User\WallpaperController@saveWallpaper');
Route::get('user/getWallpapersList', $baseControllerNameSpace.'User\WallpaperController@getWallpapersList');

Route::get('user/getDraftWallpaper', $baseControllerNameSpace.'User\WallpaperController@getDraftWallpaper');
Route::post('user/saveWallpaperToDraft', $baseControllerNameSpace.'User\WallpaperController@saveWallpaperToDraft');


Route::get('user/deleteWallpaper/{id}', $baseControllerNameSpace.'User\WallpaperController@deleteWallpaper');





/*-----------------------------api for Banking ---------------------------------*/

Route::post('user/saveBankInformation', $baseControllerNameSpace.'User\BankingController@saveBankInformation');

Route::post('user/updateBankAccountInformation', $baseControllerNameSpace.'User\BankingController@updateBankAccountInformation');

Route::post('user/updateCompanyInformation', $baseControllerNameSpace.'User\BankingController@updateCompanyInformation');
Route::post('user/updateBankInitialDepositAmount', $baseControllerNameSpace.'User\BankingController@updateBankInitialDepositAmount');


/*------------------------------------------------------------------------------------*/
/*----------------/-\----|admin apis---------------------------------------------------*/
/*---------------/---\---|------------------------------------------------------------*/
/*--------------/-----\--|------------------------------------------------------------*/
/*------------------------------------------------------------------------------------*/

Route::get('admin/getAllUsers', $baseControllerNameSpace.'Admin\UserController@getAllUsers');
Route::get('admin/onDeleteUser/{id}', $baseControllerNameSpace.'Admin\UserController@onDeleteUser');
Route::get('admin/getUserById/{id}', $baseControllerNameSpace.'Admin\UserController@getUserById');
Route::post('admin/updateStatus', $baseControllerNameSpace.'Admin\UserController@updateStatus');

Route::get('admin/getUserDetails/{id}', $baseControllerNameSpace.'Admin\UserController@getUserDetails');


Route::get('admin/resetUserData/{id}', $baseControllerNameSpace.'Admin\UserController@resetUserData');







/*----------------------------Quotes-----------------------------*/
Route::post('admin/addQuote', $baseControllerNameSpace.'Admin\QuoteController@addQuote');
Route::get('admin/getAllQuotes', $baseControllerNameSpace.'Admin\QuoteController@getAllQuotes');
Route::get('admin/deleteQuoteById/{id}', $baseControllerNameSpace.'Admin\QuoteController@deleteQuoteById');
Route::post('admin/saveInstructionVideo', $baseControllerNameSpace.'Admin\SettingsController@saveInstructionVideo');

// practice check
Route::get('admin/getUnitsListWithQuestions', $baseControllerNameSpace.'Admin\PracticeCheckQuestionController@getUnitsListWithQuestions');
Route::get('admin/updateUnitTitle', $baseControllerNameSpace.'Admin\PracticeCheckQuestionController@updateUnitTitle');
Route::post('admin/addUnitQuestionPhrasesAndAnswer', $baseControllerNameSpace.'Admin\PracticeCheckQuestionController@addUnitQuestionPhrasesAndAnswer');
Route::post('admin/updateUnitQuestionPhrasesAndAnswer', $baseControllerNameSpace.'Admin\PracticeCheckQuestionController@updateUnitQuestionPhrasesAndAnswer');
Route::get('admin/getSelectedQuestionDetail', $baseControllerNameSpace.'Admin\PracticeCheckQuestionController@getSelectedQuestionDetail');
Route::post('admin/updateUnitTileAndDescription', $baseControllerNameSpace.'Admin\PracticeCheckQuestionController@updateUnitTileAndDescription');

Route::get('admin/deleteQuestion/{question_id}', $baseControllerNameSpace.'Admin\PracticeCheckQuestionController@deleteQuestion');



// video review
Route::get('admin/getUnitsListWithVideoQuestions', $baseControllerNameSpace.'Admin\VideoReviewQuestionController@getUnitsListWithVideoQuestions');
Route::post('admin/addUnitVideoQuestionPhrasesAndAnswer', $baseControllerNameSpace.'Admin\VideoReviewQuestionController@addUnitVideoQuestionPhrasesAndAnswer');

Route::get('admin/deleteVideoQuestion/{question_id}', $baseControllerNameSpace.'Admin\VideoReviewQuestionController@deleteVideoQuestion');


Route::get('admin/getSelectedVideoQuestionDetail', $baseControllerNameSpace.'Admin\VideoReviewQuestionController@getSelectedVideoQuestionDetail');
Route::post('admin/updateUnitVideoQuestionPhrasesAndAnswer', $baseControllerNameSpace.'Admin\VideoReviewQuestionController@updateUnitVideoQuestionPhrasesAndAnswer');
Route::get('user/getSelectedVideoQuestionDetailById/{questionId}', $baseControllerNameSpace.'User\VideoReviewQuestionController@getSelectedVideoQuestionDetailById');
Route::get('user/getUserAvailableVideoQuestionId', $baseControllerNameSpace.'User\VideoReviewQuestionController@getUserAvailableVideoQuestionId');
Route::post('user/submitUnitVideoQuestionAnswer', $baseControllerNameSpace.'User\VideoReviewQuestionController@submitUnitVideoQuestionAnswer');

/*----------------------exports files ------------------------------*/

Route::get('admin/downloadFile',$baseControllerNameSpace.'Admin\UserController@downloadFile');






/*-------------------------Responses crude------------------------------*/

Route::get('admin/getPracticeCheckResponses',$baseControllerNameSpace.'Admin\SettingsController@getPracticeCheckResponses');
Route::get('admin/getVideoReviewResponses',$baseControllerNameSpace.'Admin\SettingsController@getVideoReviewResponses');
Route::post('admin/updateResponse',$baseControllerNameSpace.'Admin\SettingsController@updateResponse');

Route::post('admin/saveResponse',$baseControllerNameSpace.'Admin\SettingsController@saveResponse');
Route::get('admin/deleteResponse/{id}',$baseControllerNameSpace.'Admin\SettingsController@deleteResponse');



/*-------------------------BootCamp Analytics crude------------------------------*/


Route::get('admin/getAllLevels',$baseControllerNameSpace.'Admin\BootCampAnalyticsApiController@getAllLevels');

Route::post('admin/addNewActivityAlgo',$baseControllerNameSpace.'Admin\BootCampAnalyticsApiController@addNewActivityAlgo');

Route::post('admin/addNewChartAlgo',$baseControllerNameSpace.'Admin\BootCampAnalyticsApiController@addNewChartAlgo');

Route::get('admin/bootCampAnalyticsActivitiesList',$baseControllerNameSpace.'Admin\BootCampAnalyticsApiController@bootCampAnalyticsActivitiesList');

Route::get('admin/bootCampAnalyticsChartsList',$baseControllerNameSpace.'Admin\BootCampAnalyticsApiController@bootCampAnalyticsChartsList');

Route::get('admin/deleteBootCampAnalyticsChartById/{id}',$baseControllerNameSpace.'Admin\BootCampAnalyticsApiController@deleteBootCampAnalyticsChartById');

Route::get('admin/deleteBootCampAnalyticsActivityById/{id}',$baseControllerNameSpace.'Admin\BootCampAnalyticsApiController@deleteBootCampAnalyticsActivityById');

Route::get('admin/getBootCampAnalyticsChartById/{id}',$baseControllerNameSpace.'Admin\BootCampAnalyticsApiController@getBootCampAnalyticsChartById');

Route::get('admin/getBootCampAnalyticsActivityById/{id}',$baseControllerNameSpace.'Admin\BootCampAnalyticsApiController@getBootCampAnalyticsActivityById');

Route::post('admin/updateActivityById',$baseControllerNameSpace.'Admin\BootCampAnalyticsApiController@updateActivityById');

Route::post('admin/updateChartById',$baseControllerNameSpace.'Admin\BootCampAnalyticsApiController@updateChartById');
