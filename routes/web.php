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

        Route::resource('hr', 'AdminHrController');
        Route::get('HR/multiple_create', 'AdminHrController@multiple_create')->name('Overall.multiple_create');
        Route::post('HR/multiple_store', 'AdminHrController@multiple_store')->name('Overall.multiple_store');
        Route::get('HR/download', 'AdminHrController@download')->name('Overall.download');
        Route::get('HR/{id}/reset_edit', 'AdminHrController@reset_edit')->name('Overall.hr_reset_edit');
        Route::post('HR/{id}/reset_update', 'AdminHrController@reset_update')->name('Overall.hr_reset_update');
        Route::get('HR/{id}/destroy_exception', 'AdminHrController@destroy_exception')->name('Overall.hr_destroy_exception');

        Route::resource('pm', 'AdminPmController');
        Route::get('pm/{id}/schdlm', 'AdminPmController@schdlm')->name('Overall.admin_schdlm');
        Route::get('pm/{id}/result', 'AdminPmController@result')->name('Overall.admin_result');
        Route::get('PM/{id}/destroy_exception', 'AdminPmController@destroy_exception')->name('Overall.pm_destroy_exception');

        Route::prefix('search')->group(function (){
            Route::post('/hr_search','SearchController@hr_search');
            Route::post('/pm_search','SearchController@pm_search');
        });

    });
});

Route::prefix('PHMS_member')->group(function (){
    Route::prefix('login')->group(function (){
        Route::get('/','MemberController@login_form');
        Route::post('/authenticate','MemberController@authenticate');
        Route::get('/logout','MemberController@logout');
    });
    Route::group(['middleware' => 'auth.member'], function() {
        Route::get('/','MemberController@index');
    });

});
