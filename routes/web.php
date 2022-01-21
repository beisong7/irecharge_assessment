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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/','BaseController@welcome');
Route::get('customers','CustomerController@index')->name('customers.index');
Route::post('create/customer','CustomerController@store');
Route::get('customer/{id}','CustomerController@show')->name('customer.show');
Route::get('customer/transactions/{id}', 'TransactionController@customerTransactions')->name('customer.transactions');
Route::get('customer/payments/{id}', 'PaymentController@customerPayments')->name('customer.transactions');

Route::post('card/pay', 'PaymentController@initiatePayment');
Route::post('card/pay/authorised', 'PaymentController@completePayment');


