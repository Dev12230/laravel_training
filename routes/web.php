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

 Route::group(['middleware' => ['role:Admin']], function () {
//---------- Cities route -------------------

    Route::get('/cities_list', 'CitiesController@cities_list')->name('get.cities');
    Route::get('/cities', 'CitiesController@index')->name('cities.index');
    Route::get('/cities/create', 'CitiesController@create')->name('cities.create');
    Route::post('/cities', 'CitiesController@store')->name('cities.store');
    Route::patch('/cities/{city}', 'CitiesController@update')->name('cities.update');
    Route::get('/cities/{city}/edit', 'CitiesController@edit')->name('cities.edit');
    Route::delete('/cities/{city}', 'CitiesController@destroy')->name('cities.destroy');

//---------- Roles route -------------------

    Route::get('/roles_list', 'RolesController@roles_list')->name('get.roles');
    Route::get('/roles', 'RolesController@index')->name('roles.index');
    Route::get('/roles/create', 'RolesController@create')->name('roles.create');
    Route::post('/roles', 'RolesController@store')->name('roles.store');
    Route::patch('/roles/{role}', 'RolesController@update')->name('roles.update');
    Route::get('/roles/{role}/edit', 'RolesController@edit')->name('roles.edit');
    Route::delete('/roles/{role}', 'RolesController@destroy')->name('roles.destroy');
 });
