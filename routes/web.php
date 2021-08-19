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
    Route::get('/', 'CastController@index')->name('home');
    Route::get('/home', 'CastController@index');
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

    //Casting Routes
    Route::group(['middleware' => ['show']], function () {
        Route::get('cast/choices', 'CastController@choices');
        Route::get('cast/enter', 'CastController@enter');
        Route::get('cast/addrole', 'CastController@addRole');
        Route::post('cast/enter', 'CastController@storeChoice');
        Route::post('cast/addrole', 'CastController@storeRole');
    } );
    Route::resources(['cast' => 'Cast']);

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('admin', 'AdminController@index');
        Route::get('admin/meeting', 'AdminController@meeting')->name('castingMeeting');
        Route::get('admin/add', 'AdminController@add')->name('addShow');
        Route::get('admin/view', 'AdminController@view')->name('viewProductions');
        Route::get('admin/view/{id}', 'AdminController@viewSingle')->name('viewSingleProduction');
        Route::get('admin/people', 'AdminController@actors')->name('viewPeople');
        Route::get('admin/users', 'UsersController@index')->name('viewUsers');
        Route::post('admin/add', 'AdminController@addProduction');
        Route::post('admin/cast-person', 'AdminController@castPerson');
        Route::post('admin/remove', 'AdminController@deleteChoice');
        Route::post('admin/endSeason', 'AdminController@deleteAll');
        Route::post('admin/users/{id}/delete', 'UsersController@destroy');
    });


});
