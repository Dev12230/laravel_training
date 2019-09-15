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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');


//---------- cities route -------------------

Route::get('/cities_list', 'CitiesController@cities_list')->name('get.cities');
Route::get('/cities', 'CitiesController@index')->name('cities.index');
Route::get('/cities/create', 'CitiesController@create')->name('cities.create');
Route::post('/cities', 'CitiesController@store')->name('cities.store');
Route::patch('/cities/{city}', 'CitiesController@update')->name('cities.update');
Route::get('/cities/{city}/edit', 'CitiesController@edit')->name('cities.edit');
Route::delete('/cities/{city}', 'CitiesController@delete')->name('cities.delete');





