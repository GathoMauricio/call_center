<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Account;
use App\RepitedAccount;

class ReportController extends Controller
{
    public function index()
    {
        $dates = Account::selectRaw('DISTINCT CAST(created_at AS DATE) AS date_db')->orderBy('date_db','DESC')->get();
        return view('report',['dates' => $dates]);
    }
    public function dbReport($date)
    {
        $repited = count(RepitedAccount::whereDate('created_at',$date)->get());
        $total = count(Account::whereDate('created_at',$date)->get());
        $pdf = \PDF::loadView('db_report_pdf',['date' => $date, 'total' => $total, 'repited' => $repited]);
        return $pdf->stream('Resultado saldos '.$date.'.pdf');
    }
}
