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

Route::get('/home', 'HomeController@index')->name('home');


    //---------- Cities route -------------------
    Route::get('/cities_list', 'CitiesController@getCities')->name('get.cities');
    Route::get('/cities', 'CitiesController@index')->name('cities.index');
    Route::get('/cities/create', 'CitiesController@create')->name('cities.create');
    Route::post('/cities', 'CitiesController@store')->name('cities.store');
    Route::patch('/cities/{city}', 'CitiesController@update')->name('cities.update');
    Route::get('/cities/{city}/edit', 'CitiesController@edit')->name('cities.edit');
    Route::delete('/cities/{city}', 'CitiesController@destroy')->name('cities.destroy');

    //---------- staff route -------------------

    Route::get('/roles_list', 'RolesController@getRoles')->name('get.roles');
    Route::get('/roles', 'RolesController@index')->name('roles.index');
    Route::get('/roles/create', 'RolesController@create')->name('roles.create');
    Route::post('/roles', 'RolesController@store')->name('roles.store');
    Route::patch('/roles/{role}', 'RolesController@update')->name('roles.update');
    Route::get('/roles/{role}/edit', 'RolesController@edit')->name('roles.edit');
    Route::delete('/roles/{role}', 'RolesController@destroy')->name('roles.destroy');

    //------------Jobs route -------------------

    Route::get('/jobs_list', 'JobsController@getjobs')->name('get.jobs');
    Route::get('/jobs', 'JobsController@index')->name('jobs.index');
    Route::get('/jobs/create', 'JobsController@create')->name('jobs.create');
    Route::post('/jobs', 'JobsController@store')->name('jobs.store');
    Route::patch('/jobs/{job}', 'JobsController@update')->name('jobs.update');
    Route::get('/jobs/{job}/edit', 'JobsController@edit')->name('jobs.edit');
    Route::delete('/jobs/{job}', 'JobsController@destroy')->name('jobs.destroy');


    //------------staff route -------------------

    Route::get('/staff_list', 'StaffController@getstaff')->name('get.staff');
    
    Route::get('get-cities','StaffController@getCities');


    Route::get('/staff', 'StaffController@index')->name('staff.index');
    Route::get('/staff/create', 'StaffController@create')->name('staff.create');
    Route::post('/staff', 'StaffController@store')->name('staff.store');
    Route::patch('/staff/{staff}', 'StaffController@update')->name('staff.update');
    Route::get('/staff/{staff}/edit', 'StaffController@edit')->name('staff.edit');
    Route::delete('/staff/{staff}', 'StaffController@destroy')->name('staff.destroy');