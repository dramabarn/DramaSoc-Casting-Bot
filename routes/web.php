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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();


Route::group(['middleware' => ['get.menu', 'auth']], function () {
    //General Routes
    Route::get('/', 'Cast@index')->name('home');
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

    //Casting Routes
    Route::group(['middleware' => ['show']], function () {
        Route::get('cast/choices', 'Cast@choices');
        Route::get('cast/enter', 'Cast@enter');
        Route::get('cast/addrole', 'Cast@addRole');
        Route::post('cast/enter', 'Cast@storeChoice');
        Route::post('cast/addrole', 'Cast@storeRole');
    } );
    Route::resources(['cast' => 'Cast']);

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('admin', 'AdminController@index');
        Route::get('admin/meeting', 'AdminController@meeting')->name('castingMeeting');
        Route::get('admin/add', 'AdminController@add')->name('addShow');
        Route::get('admin/view', 'AdminController@view')->name('viewProductions');
        Route::get('admin/people', 'AdminController@people')->name('viewPeople');
        Route::post('admin/add', 'AdminController@addProduction');
        Route::post('admin/cast-person', 'AdminController@castPerson');
        Route::post('admin/remove', 'AdminController@deleteChoice');
    });


});
