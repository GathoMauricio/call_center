<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Goutte\Client;
use App\Exports\ScrapingExport;
use Maatwebsite\Excel\Facades\Excel;
use App\ScrapingList;
use App\ScrapingCredential;
use App\ScrapingAccount;
class ScrapingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $credentials = ScrapingCredential::first();
        if(empty($credentials))
        {
            $credentials = [[
                'user' => 'Undefined',
                'password' => 'Undefined'
            ]];
        }
        return view('scraping',['credentials' => $credentials]);
    }
    public function result_ajax(Request $request, Client $client)
    {
        
        $credentials = ScrapingCredential::first();
        if($credentials->user != $request->user)
        {
            $credentials->user = $request->user;
        }
        if($credentials->password != $request->password)
        {
            $credentials->password = $request->password;
        }
        $credentials->save();
        //save crawler on cache
        if(!\Cache::has('crawler'))
        {
            $crawler = $client->request('GET', 'http://proveedoreco.infonavit.org.mx/proveedoresEcoWeb/');
            $form = $crawler->filter("form")->form();
            $crawler = $client->submit($form, ['usuario' => $credentials->user, 'password' => $credentials->password]);
            \Cache::put('crawler',$crawler, 10);
        }else{
            $crawler = \Cache::get('crawler');
        }
        try{
            sleep(10);
            $form = $crawler->filter("form")->form();
            $crawler = $client->submit($form, [
                'numeroCredito' => $request->account
            ]);
            $message = $crawler->filter('.system_title')->first();
            if(count($message) > 0){
                $scrapingList = ScrapingList::create([
                    'account' => $request->account,
                    'name' => "",
                    'amount' => "",
                    'message' => $message->text(),
                    'timestamp_id'=>$request->timestamp_id
                ]);
                //create record
                $account = ScrapingAccount::where('account',$request->account)->first();
                if(empty($account))
                {
                    ScrapingAccount::create([
                        'account' => $request->account,
                        'name' => "No disponible > ".$message->text()
                    ]);
                }
                return [
                        'account' => $request->account,
                        'name' => "",
                        'amount' => "",
                        'message' => $message->text(),
                ];
            }else{
                $section = explode('Datos del Acreditado',$crawler->filter('form[name=proveedoresForm]')->first()->text());
                $aux = explode('Nombre Acreditado: ',$section[1]);
                $aux = explode(' NSS: ',$aux[1]);
                $name = $aux[0];
                $aux = explode('Monto de la Constancia para la compra de ecotecnologías:',$section[1]);
                $aux = explode(' Ahorro Minimo',$aux[1]);
                $amount = $aux[0];
                $scrapingList = ScrapingList::create([
                    'account' => $request->account,
                    'name' => $name,
                    'amount' => $amount,
                    'message' => "",
                    'timestamp_id'=>$request->timestamp_id
                ]);
                //create record
                $account = ScrapingAccount::where('account',$request->account)->first();
                if(empty($account))
                {
                    ScrapingAccount::create([
                        'account' => $request->account,
                        'name' => $name
                    ]);
                }
                
                return [
                    'account' => $request->account,
                    'name' => $name,
                    'amount' => $amount,
                    'message' => "",
                ];
            }
        }catch(Exception $e){
            $this->result_ajax($request,$client);
        }
    }
    public function excel(Request $request)
    {
        return Excel::download(new ScrapingExport($request->timestamp_id) , 'Scraping'.formatDate(date('Y-m-d H:i')).'.xlsx');
    }
}
