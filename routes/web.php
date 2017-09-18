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

Route::get('/','CalcController@calc_init');

Route::get('allcurrencies','CalcController@get_all_currencies');

//ajax call to controller
Route::post('/getresult', 'CalcController@ajaxcall');

Route::get('ajax',function(){
   return view('message');
});

Route::post('/getmsg','AjaxController@index');

Route::get('currencies/{id}', function($id)
{
	
	$currency = DB::table('currencies')->where('cid', $id)->first();
	
	return View::make('/singlecurrency', ['currency' => $currency]);
		
})->middleware('auth');

Route::post('/getcurrency', 'CalcController@ajax_currency_update');

Route::get('/addcurrency', function(){
    return view('addcurrency');
})->middleware('auth');

Route::post('/addcurrency','CalcController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');