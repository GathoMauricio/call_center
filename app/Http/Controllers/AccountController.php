<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Account;
use App\User;
use App\UserAssignment;
use Goutte\Client;
use App\ScrapingCredential;
use App\FollowOption;
use App\RepitedAccount;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        if(\Auth::user()->user_rol_id == 1)
        {
            $assignments = UserAssignment::where('status','active')->paginate(15);
        }else{
            $assignments = UserAssignment::where('status','active')->where('user_id',\Auth::user()->id)->paginate(15);
        }
        $options = FollowOption::orderBy('option','ASC')->get();
        return view('account.account',[ 'assignments' => $assignments, 'options' => $options]);
    }
    public function indexByCodification($id)
    {
        if(\Auth::user()->user_rol_id == 1)
        {
            $assignments = UserAssignment::where('status','active')->get();
            $aux = [];
            foreach($assignments as $assignament)
            {
                if(!empty($assignament->account['follow_option_id']) && $assignament->account['follow_option_id'] == $id)
                {
                    $aux[] = $assignament;
                }
            }
            $assignments =$aux;
        }else{
            $assignments = UserAssignment::where('status','active')->where('user_id',\Auth::user()->id)->get();
            $aux = [];
            foreach($assignments as $assignament)
            {
                if(!empty($assignament->account['follow_option_id']) && $assignament->account['follow_option_id'] == $id)
                {
                    $aux[] = $assignament;
                }
            }
            $assignments =$aux;
        }
        $options = FollowOption::orderBy('option','ASC')->get();
        return view('account.account_by_codification',[ 
            'option_id' => $id,
            'assignments' => $assignments, 
            'options' => $options
            ]);
    }
    public function archivedIndex(){
        if(\Auth::user()->user_rol_id == 1)
        {
            $assignments = UserAssignment::where('status','archived')->paginate(15);
        }else{
            $assignments = UserAssignment::where('status','archived')->where('user_id',\Auth::user()->id)->paginate(15);
        }
        return view('account.archived_account',[ 'assignments' => $assignments]);
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
        $assignaments = [];
        for( $i = 1 ; $i <= sizeof($accounts) ; $i++)
        {
            if(!empty($accounts[$i][2]) && strlen($accounts[$i][2]) >= 10)
            {
                $account = Account::where('account',$accounts[$i][2])->first();
                
                if(empty($account))
                {
                    $newAccount = Account::create([
                        'phone' => $accounts[$i][0], 
                        'name' => $accounts[$i][1], 
                        'account' => $accounts[$i][2], 
                        'amount' => $accounts[$i][3], 
                        'location' => $accounts[$i][4], 
                    ]);
                    
                    $counterNews++;
                    
                    try{
                        if($this->scrapAndAssignAccount($client ,$crawler,$newAccount->account))
                        {
                            $auxAccount = Account::where('account',$newAccount->account)->first();
                            $auxAccount->amount = str_replace(['$',',',' '],'',$auxAccount->amount);
                            $auxAccount->save();
                            if(floatval($auxAccount->amount) >= 800)
                            {
                                $assignaments[] = Account::where('account',$newAccount->account)->first();
                            }
                        }
                        $newRegisters [] = Account::where('account',$newAccount->account)->first(); 
                    }catch(Exception $e){
                        $counterErrors++;
                    }

                }else{
                    $repitedAccount = Account::where('account',$accounts[$i][2])->first();
                    $repitedRegisters[] = $repitedAccount;
                    RepitedAccount::create([ 'account_id' => $repitedAccount->id]);
                    $counterRepited++;
                }
                $counterTotal++;
                $totalRegisters[] = Account::where('account',$accounts[$i][2])->first();
            }
        }
        $items = collect($assignaments)->sortBy('amount')->reverse()->toArray();
        $users = User::where('user_rol_id', 2)->where('status','active')->get();
        foreach($items as $item)
        {
            UserAssignment::create([
                'user_id' => $users[$counterUser]->id,
                'account_id' => $item['id']
            ]);
            $auxAccount = Account::where('account',$item['account'])->first();
            $auxAccount->amount = '$'.number_format($auxAccount->amount);
            $auxAccount->save();
            $assignedRegisters[] = $auxAccount;
            $counterAssigned++;
            $counterUser++;
            if($counterUser >= count(User::where('user_rol_id', 2)->where('status','active')->get())) $counterUser = 0;
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
            $accountM = Account::where('account',$account)->first();
            $accountM->message = $message->text();
            $accountM->save();
            return false;
        }else{
            $accountM = Account::where('account',$account)->first();
            $accountM->message = '';
            $accountM->save();
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
    public function archiveAccount(Request $request)
    {
        $assignment = UserAssignment::findOrFail($request->id);
        $assignment->status = 'archived';
        $assignment->save();
        return redirect()->back()->with('message','Cuenta archivada');
    }
    public function activeAccount(Request $request)
    {
        $assignment = UserAssignment::findOrFail($request->id);
        $assignment->status = 'active';
        $assignment->save();
        return redirect()->back()->with('message','Cuenta activa');
    }

    public function getMessages(Client $client){
        set_time_limit(50000);
        $credentials = ScrapingCredential::first();
        $crawler = $client->request('GET', 'http://proveedoreco.infonavit.org.mx/proveedoresEcoWeb/');
        $form = $crawler->filter("form")->form();
        $crawler = $client->submit($form, ['usuario' => $credentials->user, 'password' => $credentials->password]);

        $accounts = Account::all();
        $counter = 1;
        foreach($accounts as $account)
        {
            $message = $this->scrapMessages($client, $crawler, $account->account);
            $account->message = $message;
            $account->save();
            echo $counter." - Cuenta: ".$account->account." : ".$message." <br/>";
            $counter++;
        }
    }
    public function scrapMessages(Client $client ,$crawler, $account){
        $form = $crawler->filter("form")->form();
        $message = $crawler->filter('.system_title')->first();
        //if scrap fail and revived a message recursive the function to pass the craler logged again
        if(count($message) > 0){
            $this->scrapMessages($client ,$crawler, $account);
        }

        $crawler = $client->submit($form, [
            'numeroCredito' => $account
        ]);

        $message = $crawler->filter('.system_title')->first();
        if(count($message) > 0){
            return $message->text();
        }else{
            return '';
        }
     }
}
