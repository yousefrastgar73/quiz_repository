<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Sentinel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Illuminate\Database\Connection;

class UsersController extends Controller
{
    function __construct(Sentinel $sentinel, Connection $connection)
    {
      $this->middleware('student.auth');
      $this->sentinel = $sentinel;
      $this->connection = $connection;
    }
    
    public function showProfile()
    {
       return view('layouts.profile');
    }
    
    public function fetchScore(Request $request)
    {
        $score = $request->except('_token');
        $score = $score['totalScore'];
        $userID = $this->sentinel->getUser()->id;
        $this->connection->table('users')->where('id', $userID)->update(['total_score' => $score]);
        return 200;
    }
}
