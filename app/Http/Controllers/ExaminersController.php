<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Repositories\QuestionRepository as Question;
use Cache;

class ExaminersController extends Controller
{
    function __construct(User $user) {
        $this->user = $user;
    }
    
    public function index()
    {
        $username = $this->user->username;
        return view('layouts.examiner', ['username' => $username]);
    }
    
    public function checkStartExamFlag()
    {
        if (Redis::get('examinee') == 'online') {
            return 200;
        }
        else {
            return false;
        }
    }
    
    public function sendQuestion(Request $request)
    {
        $this->validate($request, [
            'id'             => 'required|numeric|max:15',
            'question_text'  => 'required|string',
            'option1'        => 'required|string',
            'option2'        => 'required|string',
            'option3'        => 'required|string',
            'option4'        => 'required|string',
            'score'          => 'required|numeric',
            'correct_answer' => 'required|numeric'
        ]);
        $questionArray = new Question(
            $request->input('id'),
            $request->input('question_text'),
            $request->input('option1'),
            $request->input('option2'),
            $request->input('option3'),
            $request->input('option4'),
            $request->input('score'),
            $request->input('correct_answer')
        );
        $questionArray->store();
        return 200;
    }
    
    public function checkNextQuestion()
    {
        if (Redis::get('question') == 'next') {
            return 200;
        }
        else {
            return false;
        }
    }
    
    public function checkFinishExamFlag()
    {
        if (Redis::get('examinee') == 'online') {
            return false;
        }
        else {
            return 200;
        }
    }
}
