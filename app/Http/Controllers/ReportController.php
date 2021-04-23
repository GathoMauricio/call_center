<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Account;
use App\RepitedAccount;
use App\User;
use App\AccountFollow;
use App\FollowOption;

class ReportController extends Controller
{
    public function index()
    {
        $dates = Account::selectRaw('DISTINCT CAST(created_at AS DATE) AS date_db')->orderBy('date_db','DESC')->get();
        $users = User::where('user_rol_id', 2)->get();
        return view('report',['dates' => $dates, 'users' => $users]);
    }
    public function dbReport($date, $location)
    {
        $repitedAccounts = RepitedAccount::whereDate('created_at',$date)->get();
        $repited = 0;
        foreach($repitedAccounts as $repitedAccount)
        {
            $aux = Account::where('id',$repitedAccount->account_id)->first();
            if($aux){ 
                if($aux->location == $location)
                $repited++;
             }
        }
        //return $repited;
        $total = count(Account::where('location',$location)->whereDate('created_at',$date)->get());
        $pdf = \PDF::loadView('db_report_pdf',['date' => $date, 'location' => $location, 'total' => $total, 'repited' => $repited]);
        return $pdf->stream('Resultado saldos '.$date.'.pdf');
    }
    public function userReport(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $options = FollowOption::orderBy('option')->get();
        $counters = [];
        if($request->date1 == $request->date2)
        {
            $follows = AccountFollow::
            where('author_id',$id)
            ->whereDate('created_at', $request->date1)
            ->orderBy('created_at','DESC')
            ->get();

            foreach ($options as $option)
            {
                $counters[] = [
                    'type' => $option->option,
                    'count' => count(AccountFollow::
                    where('follow_option_id',$option->id)
                    ->where('author_id',$id)
                    ->whereDate('created_at', $request->date1)
                    ->orderBy('created_at','DESC')
                    ->get())
                ];
            }

        }else{
            $follows = AccountFollow::
            where('author_id',$id)
            ->whereBetween('created_at', [$request->date1, $request->date2])
            ->orderBy('created_at','DESC')
            ->get();

            foreach ($options as $option)
            {
                $counters[] = [
                    'type' => $option->option,
                    'count' => count(AccountFollow::
                    where('follow_option_id',$option->id)
                    ->where('author_id',$id)
                    ->whereBetween('created_at', [$request->date1, $request->date2])
                    ->orderBy('created_at','DESC')
                    ->get())
                ];
            }

        }
        return view('report.user_result',[
            'counters' => $counters,
            'follows' => $follows,
            'user' => $user
            ]);
    }
    public function totalUserReport(Request $request)
    {
        $users = User::where('user_rol_id',2)->where('status','active')->orderBy('name')->get();
        $options = FollowOption::orderBy('option')->get();
        if($request->date1 == $request->date2)
        {
            $follows = AccountFollow::
            whereDate('created_at', $request->date1)
            ->orderBy('created_at','DESC')
            ->get();
        }else{
            $follows = AccountFollow::
            whereBetween('created_at', [$request->date1, $request->date2])
            ->orderBy('created_at','DESC')
            ->get();
        }
        return view('report.total_user_result',[
            'users' => $users,
            'follows' => $follows,
            'options' => $options
            ]);
    }
}
