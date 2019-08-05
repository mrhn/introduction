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

use Illuminate\Support\Facades\Route;

Route::get('/', 'CustomerController@index');

Route::group(['prefix' => 'customer'], function () {
    Route::get('/{customer}', 'CustomerController@show')->name('customer.show');
    Route::post('/invoice/{customer}', 'CustomerController@invoice')->name('customer.invoice');
});

Route::get('/invoices', 'InvoiceController@index');
