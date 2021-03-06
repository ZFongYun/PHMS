<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
    //====管理者登入====
    Route::prefix('login')->group(function (){
        Route::get('/','AdminController@login_form');
        Route::post('/authenticate','AdminController@authenticate');
        Route::get('/logout','AdminController@logout');
    });

    Route::group(['middleware' => 'auth.admin'], function() {
        //====首頁====
        Route::get('/','AdminController@index');
        //====用戶資料====
        Route::resource('userinfo', 'AdminInfoController');
        Route::get('userinfo/{id}/reset_edit', 'AdminInfoController@reset_edit')->name('Overall.reset_edit');
        Route::post('userinfo/{id}/reset_update', 'AdminInfoController@reset_update')->name('Overall.reset_update');
        //====人資管理====
        Route::resource('hr', 'AdminHrController');
        Route::get('HR/multiple_create', 'AdminHrController@multiple_create')->name('Overall.multiple_create');
        Route::post('HR/multiple_store', 'AdminHrController@multiple_store')->name('Overall.multiple_store');
        Route::get('HR/download', 'AdminHrController@download')->name('Overall.download');
        Route::get('HR/{id}/reset_edit', 'AdminHrController@reset_edit')->name('Overall.hr_reset_edit');
        Route::post('HR/{id}/reset_update', 'AdminHrController@reset_update')->name('Overall.hr_reset_update');
        Route::get('HR/{id}/destroy_exception', 'AdminHrController@destroy_exception')->name('Overall.hr_destroy_exception');
        //====專案管理====
        Route::resource('pm', 'AdminPmController');
        Route::get('pm/{id}/schdlm', 'AdminPmController@schdlm')->name('Overall.admin_schdlm');
        Route::get('pm/{id}/result', 'AdminPmController@result')->name('Overall.admin_result');
        Route::get('PM/{id}/destroy_exception', 'AdminPmController@destroy_exception')->name('Overall.pm_destroy_exception');
        //====進度管理====
        Route::prefix('pm/{id}/schdlm')->group(function (){
            Route::get('/{schdlId}/download', 'AdminPmController@schdlm_download')->name('Overall.admin_schdlm_download');
            Route::get('/{schdlId}/PA', 'AdminPmController@schdlm_pa')->name('Overall.admin_schdlm_pa');
        });
        //====搜尋====
        Route::prefix('search')->group(function (){
            Route::post('/hr_search','SearchController@hr_search');
            Route::post('/pm_search','SearchController@pm_search');
            Route::post('/schdl_search','SearchController@admin_schdl_search');
        });
    });
});

Route::prefix('PHMS_member')->group(function (){
    //====一般用戶登入====
    Route::prefix('login')->group(function (){
        Route::get('/','MemberController@login_form');
        Route::post('/authenticate','MemberController@authenticate');
        Route::get('/logout','MemberController@logout');
    });
    //====一般用戶註冊====
    Route::prefix('signup')->group(function (){
        Route::get('/','MemberController@signup_form');
        Route::post('/register','MemberController@register');
    });

    Route::group(['middleware' => 'auth.member'], function() {
        //====首頁====
        Route::get('/','MemberController@index');
        //====用戶資料====
        Route::resource('userinfo', 'MemberInfoController');
        Route::get('userinfo/{id}/reset_edit', 'MemberInfoController@reset_edit')->name('Overall.member_reset_edit');
        Route::post('userinfo/{id}/reset_update', 'MemberInfoController@reset_update')->name('Overall.member_reset_update');
        //====人資管理====
        Route::resource('hr', 'MemberHrController');
        //====專案管理====
        Route::resource('pm', 'MemberPmController');
        Route::get('pm/create','MemberPmController@create')->middleware('leader_check');
        Route::get('pm/{id}/schdlm', 'MemberPmController@schdlm')->name('Overall.member_schdlm');
        Route::get('pm/{id}/result', 'MemberPmController@result')->name('Overall.member_result');
        //====進度管理====
        Route::prefix('pm/{id}/schdlm')->group(function (){
            Route::get('/create', 'MemberPmController@schdlm_create')->name('Overall.member_schdlm_create');
            Route::post('/store', 'MemberPmController@schdlm_store')->name('Overall.member_schdlm_store');
            Route::get('/{schdlId}/edit', 'MemberPmController@schdlm_edit')->name('Overall.member_schdlm_edit');
            Route::post('/{schdlId}/update', 'MemberPmController@schdlm_update')->name('Overall.member_schdlm_update');
            Route::get('/{downloadId}/download', 'MemberPmController@schdlm_download')->name('Overall.member_schdlm_download');
            Route::get('/{schdlId}/PA', 'MemberPmController@schdlm_pa')->name('Overall.member_schdlm_pa');
        });
        //====成果展示====
        Route::prefix('pm/{id}/result')->group(function (){
            Route::get('/create', 'MemberPmController@result_create')->name('Overall.member_result_create');
            Route::post('/store', 'MemberPmController@result_store')->name('Overall.member_result_store');
            Route::get('/{resultId}/edit', 'MemberPmController@result_edit')->name('Overall.member_result_edit');
            Route::post('/{resultId}/update', 'MemberPmController@result_update')->name('Overall.member_result_update');
            Route::get('/download', 'MemberPmController@format_download')->name('Overall.format_download');
        });
        //====搜尋====
        Route::prefix('search')->group(function (){
            Route::post('/hr_search','SearchController@hr_search');
            Route::post('/pm_search','SearchController@member_pm_search');
            Route::post('/schdl_search','SearchController@schdl_search');
        });
        //====評分====
        Route::prefix('score')->group(function (){
            Route::post('/store','ScoreController@score_store');
            Route::post('/update','ScoreController@score_update');
        });
    });
});
