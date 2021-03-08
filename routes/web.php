<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'SaleController@index')->name('home');
Route::get('configuration', function(){ return view('configuration'); })->name('configuration');

Route::get('goals','GoalController@index')->name('goals');
Route::get('create_goal','GoalController@create')->name('create_goal');
Route::post('store_goal','GoalController@store')->name('store_goal');
Route::get('edit_goal/{id}','GoalController@edit')->name('edit_goal');
Route::put('update_goal/{id}','GoalController@update')->name('update_goal');
Route::delete('delete_goal/{id}','GoalController@destroy')->name('delete_goal');

Route::get('sales','SaleController@index')->name('sales');
Route::get('create_sale','SaleController@create')->name('create_sale');
Route::post('store_sale','SaleController@store')->name('store_sale');
Route::get('edit_sale/{id}','SaleController@edit')->name('edit_sale');
Route::put('update_sale/{id}','SaleController@update')->name('update_sale');
Route::get('delete_sale/{id?}','SaleController@destroy')->name('delete_sale');

Route::get('users','UserController@index')->name('users');
Route::get('create_user','UserController@create')->name('create_user');
Route::post('store_user','UserController@store')->name('store_user');
Route::get('edit_user/{id}','UserController@edit')->name('edit_user');
Route::put('update_user/{id}','UserController@update')->name('update_user');
Route::get('delete_user/{id?}','UserController@destroy')->name('delete_user');

Route::get('monitor','MonitorController@index')->name('monitor');

Route::get('scraping','ScrapingController@index')->name('scraping');
Route::post('migeocasa_result_ajax','ScrapingController@result_ajax')->name('migeocasa_result_ajax');
Route::get('scraping_excel','ScrapingController@excel')->name('scraping_excel');


Route::get('edit_account/{id}','ScrapingAccountController@edit')->name('edit_account');
Route::put('update_account/{id}','ScrapingAccountController@update')->name('update_account');

Route::get('account','AccountController@index')->name('account');
Route::get('account_by_codification/{id?}','AccountController@indexByCodification')->name('account_by_codification');
Route::get('archived_account','AccountController@archivedIndex')->name('archived_account');
Route::get('upload_csv','AccountController@uploadCsv')->name('upload_csv');
Route::post('store_csv','AccountController@storeCsv')->name('store_csv');
Route::put('update_credentials','AccountController@updateCredentials')->name('update_credentials');
Route::get('reasign_edit','AccountController@reasignEdit')->name('reasign_edit');
Route::put('reasign_update','AccountController@reasignUpdate')->name('reasign_update');
Route::get('archive_account','AccountController@archiveAccount')->name('archive_account');
Route::get('active_account','AccountController@activeAccount')->name('active_account');

Route::get('index_account_follow','AccountFollowController@indexAjax')->name('index_account_follow');
Route::post('store_account_follow','AccountFollowController@store')->name('store_account_follow');

Route::get('follow_options','FollowOptionController@index')->name('follow_options');
Route::get('follow_option_create','FollowOptionController@create')->name('follow_option_create');
Route::get('follow_option_edit/{id}','FollowOptionController@edit')->name('follow_option_edit');
Route::post('follow_option_store','FollowOptionController@store')->name('follow_option_store');
Route::put('follow_option_update/{id}','FollowOptionController@update')->name('follow_option_update');

Route::get('details','DetailsController@index')->name('details');
Route::get('helper',function(){
    $cuentas = App\Account::get();
    $users = App\User::where('user_rol_id', 2)->where('status','active')->get();
    $counterUser = 0;
    $num = count($users);
    $total = 0;
    foreach($cuentas as $cuenta)
    {
        $monto = str_replace(['$',',',' '],'',$cuenta->amount);
        if(strlen($monto > 0) && floatval($monto) >= 800)
        {
            if(floatval($monto) < 5000 && floatval($monto) >= 800)
            {
                $asignamiento = App\UserAssignment::where('account_id',$cuenta->id)->first();
                
                if(empty($asignamiento))
                {
                    App\UserAssignment::create([
                    'user_id' => $users[$counterUser]->id,
                    'account_id' => $cuenta['id']
                    ]);
                    $counterUser++;
                    if($counterUser >= $num) $counterUser = 0;
                    $total++;

                    $cuenta->amount = '$'.number_format($monto);
                    $cuenta->save();
                }
            }
        }
        
    }
    return "Total: ".$total;
})->name('helper');