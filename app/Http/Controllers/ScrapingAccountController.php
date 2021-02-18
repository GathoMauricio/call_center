<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ScrapingAccount;

class ScrapingAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $accounts = ScrapingAccount::paginate(15);
        return view('accounts',['accounts' => $accounts]);
    }
    public function edit($id)
    {
        $account = ScrapingAccount::findOrfail($id);
        return view('edit_account',['account' => $account]);
    }
    public function update(Request $request, $id)
    {
        $account = ScrapingAccount::findOrfail($id);
        $account->name = $request->name;
        $account->save();
        return redirect()->back()->with('message','Registro actualizado');
    }
}
