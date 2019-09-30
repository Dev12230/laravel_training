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

\DB::listen(function ($sql) {
    logger($sql->sql);
});


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['middleware'=>'is-ban','auth'], function(){

    Route::get('/home', 'HomeController@index')->name('home');
    //---------- Cities route -------------------
    Route::resource('cities', 'CitiesController');
    //---------- staff route -------------------
    Route::group(['middleware' => ['role:Admin']], function () {
        
    Route::resource('roles', 'RolesController');
     });
    //------------Jobs route -------------------
    Route::resource('jobs', 'JobsController');
    //------------staff route -------------------
    Route::resource('staff', 'StaffController');

    Route::get('get-cities','StaffController@getCities');
    Route::get('/staff/{staff}/active', 'StaffController@deActive')->name('staff.deActive');
    Route::get('/staff/{staff}/deactive', 'StaffController@Active')->name('staff.active');
});