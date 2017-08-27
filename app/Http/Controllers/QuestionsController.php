<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use App\Repositories\QuestionRepository as Question;
use Cache;

class QuestionsController extends Controller
{
    function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function index()
    {
        $users = $this->user->all();
        return view('layouts.questions', compact('users'));
    }
    
    public function cache()
    {
        var_dump(Redis::get('examinee'));
        echo '<br>---------------------------------------------------------------<br>';
        var_dump(Redis::get('question'));
        echo '<br>---------------------------------------------------------------<br>';
        $questions = json_decode(Question::getAll());
        foreach ($questions as $question) {
            var_dump($question);
            echo '<br>---------------------------------------------------------------<br>';
        }
    }
    
    public function setStartExamFlag()
    {
        Redis::set('examinee', 'online');
        return 200;
    }

    public function fetchQuestion(Request $request)
    {
        $id = $request->input('id');
        $question = Question::find($id);
        return json_encode($question);
    }
    
    public function nextQuestion()
    {
        Redis::set('question', 'next');
        return 200;
    }
    
    public function waitQuestion()
    {
        Redis::set('question', 'wait');
        return 200;
    }
    
    public function clearCache()
    {
        Cache::flush();
        return 'Cache Cleared';
    }
}
