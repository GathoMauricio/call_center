<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AccountFollow;

class AccountFollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function indexAjax(Request $request)
    {
        $follows = AccountFollow::where('account_id',$request->account_id)->orderBy('created_at','ASC')->get();
        $json = [];
        foreach($follows as $follow)
        {
            $date = explode('T',$follow->created_at);
            $date = explode(' ',$date[0]);
            $time = explode(':',$date[1]);
            $json[] = [
                'codification' => $follow->option['option'],
                'user' => $follow->author['name'].' '.$follow->author['middle_name'].' '.$follow->author['last_name'],
                'body' => $follow->body,
                'date' => $date[0].' '.$time[0].':'.$time[1]
            ];
        }
        return $json;
    }
    public function store(Request $request)
    {
        $follow = AccountFollow::create($request->all());
        $follows = AccountFollow::where('account_id',$request->account_id)->orderBy('created_at','ASC')->get();
        $json = [];
        foreach($follows as $follow)
        {
            $date = explode('T',$follow->created_at);
            $date = explode(' ',$date[0]);
            $time = explode(':',$date[1]);
            $json[] = [
                'codification' => $follow->option['option'],
                'user' => $follow->author['name'].' '.$follow->author['middle_name'].' '.$follow->author['last_name'],
                'body' => $follow->body,
                'date' => $date[0].' '.$time[0].':'.$time[1]
            ];
        }
        return $json;
    }
}
