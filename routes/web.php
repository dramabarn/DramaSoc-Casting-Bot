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
    Route::get('/', 'Cast@index')->name('home');
    Route::get('cast/choices', 'Cast@choices');
    Route::get('cast/enter', 'Cast@enter');
    Route::post('cast/enter', 'Cast@storeChoice');
    Route::get('cast/addrole', 'Cast@addRole');
    Route::post('cast/addrole', 'Cast@storeRole');
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');



    Route::resources([
        'cast' => 'Cast']);

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('admin', 'AdminController@index');
        Route::get('admin/temp', 'AdminController@getSharingCasts');
        Route::get('admin/temp-dead', 'AdminController@deadlock');
        Route::get('admin/meeting', 'AdminController@meeting')->name('castingMeeting');
        Route::post('admin/cast-person', 'AdminController@castPerson');
        Route::get('admin/add', 'AdminController@add')->name('addShow');
        Route::get('admin/view', 'AdminController@view')->name('viewProductions');
        Route::get('admin/people', 'AdminController@people')->name('viewPeople');
    });
});
