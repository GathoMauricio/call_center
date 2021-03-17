<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Account;
use DB;

class ReportController extends Controller
{
    public function index()
    {
        $dates = Account::selectRaw('DISTINCT CAST(created_at AS DATE) AS date_db')->orderBy('date_db','DESC')->get();
        return view('report',['dates' => $dates]);
    }
    public function dbReport($date)
    {
        $msgs = \App\Account::distinct()->where('created_at','LIKE','%'.$date.'%')->get('message');
        $stickersCount = 0;
        $lowAmount = 0;
        $processable = 0;
        foreach($msgs as $msg) { 
            if(!empty($msg->message))
            {
                $count=count(\App\Account::where('message',$msg->message)->get());
                $stickersCount+=$count;
            }
        }
        $accounts = \App\Account::where('message','')->where('created_at','LIKE','%'.$date.'%')->get();
        foreach($accounts as $account)
        {
            $amount = str_replace(['$',',',' '], '', $account->amount);
            if(floatval($amount < 800))
            {
                $lowAmount++;
            }else{
                $processable++;
            }
        }
        $total = ($stickersCount + $lowAmount + $processable);

        $pdf = \PDF::loadView('db_report_pdf',['date' => $date, 'total' => $total]);
        return $pdf->stream('Resultado saldos '.$date.'.pdf');
        }

        

}
