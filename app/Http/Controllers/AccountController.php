<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Account;
use App\User;
use App\UserAssignment;
use Goutte\Client;
use App\ScrapingCredential;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        if(\Auth::user()->user_rol_id == 1)
        {
            $assignments = UserAssignment::paginate(15);
        }else{
            $assignments = UserAssignment::where('user_id',\Auth::user()->id)->paginate(15);
        }
        return view('account.account',[ 'assignments' => $assignments]);
    }
    public function uploadCsv()
    {
        
        $credentials = ScrapingCredential::first();
        return view('account.upload_csv',['credentials' => $credentials]);
    }
    public function storeCsv(Request $request, Client $client)
    {
        set_time_limit(50000);
        $file = $request->file('file');
        $accounts = readCSV($file,array('delimiter' => ','));
        $counterTotal = 0;
        $counterNews = 0;
        $counterRepited = 0;
        $counterAssigned = 0;
        $counterErrors = 0;

        $totalRegisters = [];
        $newRegisters = [];
        $repitedRegisters = [];
        $assignedRegisters = [];

        $counterUser = 0;
        $credentials = ScrapingCredential::first();
        $crawler = $client->request('GET', 'http://proveedoreco.infonavit.org.mx/proveedoresEcoWeb/');
        $form = $crawler->filter("form")->form();
        $crawler = $client->submit($form, ['usuario' => $credentials->user, 'password' => $credentials->password]);

        for( $i = 1 ; $i <= sizeof($accounts) ; $i++)
        {
            if(!empty($accounts[$i][2]) && strlen($accounts[$i][2]) >= 10)
            {
                $account = Account::where('account',$accounts[$i][2])->first();
                
                if(empty($account))
                {
                    
                    //Insert new account
                    $newAccount = Account::create([
                        'phone' => $accounts[$i][0], 
                        'name' => $accounts[$i][1], 
                        'account' => $accounts[$i][2], 
                        'amount' => $accounts[$i][3], 
                        'location' => $accounts[$i][4], 
                    ]);
                    
                    $counterNews++;
                    //scraping account
                    try{
                        if($this->scrapAndAssignAccount($client ,$crawler,$newAccount->account))
                        {
                            $users = User::where('user_rol_id', 2)->where('status','active')->get();
                            UserAssignment::create([
                                'user_id' => $users[$counterUser]->id,
                                'account_id' => $newAccount->id
                            ]);
                            $assignedRegisters[] = Account::where('account',$newAccount->account)->first();
                            $counterAssigned++;
                            $counterUser++;
                            if($counterUser >= count(User::where('user_rol_id', 2)->where('status','active')->get())) $counterUser = 0;
                        }
                        $newRegisters [] = Account::where('account',$newAccount->account)->first(); 
                    }catch(Exception $e){
                        $counterErrors++;
                    }

                }else{
                    $repitedRegisters[] = Account::where('account',$accounts[$i][2])->first();
                    $counterRepited++;
                }
                $counterTotal++;
                $totalRegisters[] = Account::where('account',$accounts[$i][2])->first();
            }
        }
        return view('account.upload_result',[
            'counterTotal' => $counterTotal,
            'counterNews' => $counterNews,
            'counterRepited' => $counterRepited,
            'counterAssigned' => $counterAssigned,
            'counterErrors' => $counterErrors,

            'totalRegisters' => $totalRegisters,
            'newRegisters' => $newRegisters,
            'repitedRegisters' => $repitedRegisters,
            'assignedRegisters' => $assignedRegisters
        ]);
    }

    public function scrapAndAssignAccount(Client $client ,$crawler, $account){
        $form = $crawler->filter("form")->form();
        $message = $crawler->filter('.system_title')->first();
        //if scrap fail and revived a message recursive the function to pass the craler logged again
        if(count($message) > 0){
            $this->scrapAndAssignAccount($client ,$crawler, $account);
        }

        $crawler = $client->submit($form, [
            'numeroCredito' => $account
        ]);

        $message = $crawler->filter('.system_title')->first();
        //if the consult return a message text this record not work
        if(count($message) > 0){
            return false;
        }else{
            //if not message on this step obtain information
            $section = explode('Datos del Acreditado',$crawler->filter('form[name=proveedoresForm]')->first()->text());
            $aux = explode('Nombre Acreditado: ',$section[1]);
            $aux = explode(' NSS: ',$aux[1]);
            $name = $aux[0];
            $aux = explode('Monto de la Constancia para la compra de ecotecnologías:',$section[1]);
             $aux = explode(' Ahorro Minimo',$aux[1]);
            $amount = $aux[0];
            //update the amount of current account
            $account = Account::where('account',$account)->first();
            $account->name = $name;
            $account->amount = $amount;
            $account->save();
            return true;
        }
    }
    public function updateCredentials(Request $request)
    {
        $credentials = ScrapingCredential::first();
        $credentials->user = $request->user;
        $credentials->password = $request->password;
        $credentials->save();
        return redirect()->back()->with('message','Credenciales actualizadas..');
    }
    public function reasignEdit(Request $request)
    {
        $assignment = UserAssignment::findOrFail($request->assignment_id);
        $operators = User::where('status','active')->where('user_rol_id',2)->get();
        return [
            'actual_user_id' => $assignment->user_id,
            'assignment_id' => $assignment->id,
            'operators' => $operators
        ];
    }
    public function reasignUpdate(Request $request)
    {
        $assignment = UserAssignment::findOrFail($request->id);
        $assignment->user_id = $request->user_id;
        $assignment->save();
        return [
            'assignment_id' => $assignment->id,
            'operator' => $assignment->user['name'].' '.$assignment->user['middle_name'].' '.$assignment->user['last_name'],
            'message' => 'Cuenta reasignada.'
        ];
    }
}
