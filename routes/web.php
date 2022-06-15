<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', 'Customer\DisplayController@index')->name('customer.view.index'); 
Route::middleware(['AuthCustomer:login'])->group(function () {
    Route::get('/login', 'Customer\DisplayController@login')->name('customer.view.login'); 
});
Route::middleware(['AuthCustomer:logined'])->group(function () { 
    Route::post('logout', 'Customer\AuthController@logout')->name('customer.logout');
    Route::get('home', 'Customer\DisplayController@home')->name('customer.view.home');
}); 
// xác nhận người dùng
Route::get('confirm', 'Customer\AuthController@confirm')->name('customer.confirm');

Route::prefix('customer')->group(function () {
    Route::prefix('api')->group(function () {
        Route::prefix('auth')->group(function () { 
            Route::post('register', 'Customer\AuthController@register')->name('customer.auth.register');
        }); 
    });
});

