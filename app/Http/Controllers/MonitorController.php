<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goal;
use App\Sale;

class MonitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $goal = Goal::where('date',date('Y-m').'-01')->first();
        $sales = Sale::where('date',$goal->date)->get();
        $totalSales = 0;
        foreach($sales as $sale)
        {
            $totalSales += floatval($sale->amount);
        }
        $currentPercent = ($totalSales * 100) / $goal->objetive;
        return view('monitor',[
            'goal' => $goal,
            'totalSales' => $totalSales,
            'currentPercent' => $currentPercent
        ]); 
    }
}
