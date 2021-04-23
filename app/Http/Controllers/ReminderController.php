<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reminder;

class ReminderController extends Controller
{
    public function index()
    {
        if(\Auth::user()->user_rol_id == 1)
        {
            $reminders = Reminder::where('date',date('Y-m-d'))->get();
        }else{
            $reminders = Reminder::where('user_id', \Auth::user()->id)->where('date',date('Y-m-d'))->get();
        }
        return view('reminders.index',['reminders' => $reminders]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $reminder = Reminder::create($request->all());
        if($reminder){
            return $reminder;
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
