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

Route::prefix('PHMS_admin')->group(function (){
    Route::prefix('login')->group(function (){
        Route::get('/','AdminController@login_form');
        Route::post('/authenticate','AdminController@authenticate');
        Route::get('/logout','AdminController@logout');
    });

    Route::group(['middleware' => 'auth.admin'], function() {
        Route::get('/','AdminController@index');
        Route::resource('userinfo', 'AdminInfoController');
        Route::get('userinfo/{id}/reset_edit', 'AdminInfoController@reset_edit')->name('Overall.reset_edit');
        Route::post('userinfo/{id}/reset_update', 'AdminInfoController@reset_update')->name('Overall.reset_update');
    });
});


