<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Question;
use App\Models\Phrase;
use App\Models\Answer;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Facades\Services\UnitService;

class PracticeCheckQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function getUnitsListWithQuestions()
    {
        $unitsWithQuestions = Unit::with(['questions' => function($query){
            $query->with('answers', 'phrases');
            $query->orderBy('number');
        }])->get();
        return $unitsWithQuestions;
    }
    public function updateUnitTitle(Request $request)
    {
        $unitObj = Unit::find($request['unitId']);
        
        $unitObj->update(['title'=>$request['unitTitle']]);
        
        return $unitObj;
    }
    public function addUnitQuestionPhrasesAndAnswer(Request $request)
    {
        UnitService::addUnitQuesiton($request->all());
        return $this->getUnitsListWithQuestions();
    }

    public function updateUnitQuestionPhrasesAndAnswer(Request $request)
    {
        UnitService::updateUnitQuesiton($request->all());
        return $this->getUnitsListWithQuestions();
    }





    public function getSelectedQuestionDetail(Request $request)
    {
        $question = getQuestionById($request->questionId);
        $questionPhrasesList = Phrase::where('question_id', $question->id)->get();
        $answersList = Answer::where('question_id', $question->id)->get();

        $data = [
            'questionId' => $question->id,
            'questionNumber' => $question->number,
            'phrasesList' => $questionPhrasesList,
            'answersList' => $answersList
        ];
        return $data;
        // return response()->json($data, 200);


    }

    public function updateUnitTileAndDescription(Request $request){
            

            $unit = Unit::where('id',$request->id)->first();
            $unit->title = $request->title;
            $unit->description = $request->description;
            $unit->save();
            
            return 200;
        
    }




    public function deleteQuestion($question_id){
        $question = Question::find($question_id);
        if(isset($question)){
            $question->delete();
        }
        return 1;
    }

            

}