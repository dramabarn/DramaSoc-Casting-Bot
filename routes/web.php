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
Auth::routes();


Route::group(['middleware' => ['get.menu', 'auth']], function () {
    Route::get('/', 'Cast@index')->name('home');
    Route::get('cast/choices', 'Cast@choices');
    Route::get('cast/enter', 'Cast@enter');
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');



    Route::resources([
        'cast' => 'Cast']);

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('admin', 'AdminController@index');
        Route::get('admin/meeting', 'AdminController@meeting')->name('castingMeeting');
        Route::get('admin/add', 'AdminController@add')->name('addShow');
        Route::get('admin/view', 'AdminController@view')->name('viewProductions');
        Route::get('admin/people', 'AdminController@people')->name('viewPeople');
    });
});
