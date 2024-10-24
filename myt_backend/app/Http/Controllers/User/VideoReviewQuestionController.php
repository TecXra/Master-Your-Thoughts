<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Facades\Services\VideoReviewService;
use Auth;

use Facades\Services\UnitService;


class VideoReviewQuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getSelectedVideoQuestionDetailById($question_id)
    {
        $authUser = Auth::User();
        return VideoReviewService::getSelectedVideoQuestionDetailById($question_id,$authUser->id);
    }
    public function getUserAvailableVideoQuestionId(Request $request)
    {
        return VideoReviewService::getUserAvailableVideoQuestionId($request->user_id);
    }
    public function submitUnitVideoQuestionAnswer(Request $request)
    {
        $authUser = Auth::User();
        return VideoReviewService::submitUnitVideoQuestionAnswer($request->all(),$authUser->id);
    }
    public function getUnitVideoQuestionAnswerResponse(Request $request)
    {
        $authUser = Auth::User();
        return VideoReviewService::getUnitVideoQuestionAnswerResponse($request->all(),$authUser->id);
    }

}
