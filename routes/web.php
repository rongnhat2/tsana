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
Route::get('confirm-invite', 'Customer\CollabController@confirm')->name('customer.invite.confirm');

Route::prefix('customer')->group(function () {
    Route::prefix('api')->group(function () {
        Route::prefix('auth')->group(function () { 
            Route::post('register', 'Customer\AuthController@register')->name('customer.auth.register');
            Route::post('login', 'Customer\AuthController@login')->name('customer.auth.login');
            Route::post('logout', 'Customer\AuthController@logout')->name('customer.auth.logout');
        }); 
        Route::prefix('collab')->group(function () { 
            Route::get('get', 'Customer\CollabController@get')->name('customer.collab.get');
            Route::get('get-assign', 'Customer\CollabController@get_assign')->name('customer.collab.get_assign');
            Route::post('sending', 'Customer\CollabController@sending')->name('customer.collab.sending');
        }); 
        Route::prefix('task')->group(function () {  
            Route::get('get', 'Customer\TaskController@get')->name('customer.task.get');
            Route::get('get-one', 'Customer\TaskController@get_one')->name('customer.task.get_one');
            Route::get('on-done', 'Customer\TaskController@on_done')->name('customer.task.on_done');
            Route::post('create', 'Customer\TaskController@create')->name('customer.task.create');
            Route::post('update', 'Customer\TaskController@update')->name('customer.task.update');
        }); 
        Route::prefix('subtask')->group(function () {  
            Route::get('get', 'Customer\SubTaskController@get')->name('customer.subtask.get');
            Route::get('update', 'Customer\SubTaskController@update')->name('customer.collab.update');
            Route::get('delete', 'Customer\SubTaskController@delete')->name('customer.collab.delete');
            Route::get('get-one', 'Customer\SubTaskController@get_one')->name('customer.subtask.get_one');
            Route::post('create', 'Customer\SubTaskController@create')->name('customer.subtask.create');
        }); 
        Route::prefix('project')->group(function () {  
            Route::post('create', 'Customer\ProjectController@create')->name('customer.project.create');
            Route::get('get', 'Customer\ProjectController@get')->name('customer.project.get');
            // Route::get('get-one', 'Customer\TaskController@get_one')->name('customer.task.get_one');
            // Route::post('update', 'Customer\TaskController@update')->name('customer.task.update');
        }); 
    });
});

