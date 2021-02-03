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

Route::get('monitor', function(){ 
    $goal = App\Goal::where('date',date('Y-m').'-01')->first();
    $sales = App\Sale::where('date',$goal->date)->get();
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
})->name('monitor');