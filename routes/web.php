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
Route::group(['middleware'=>'is-active','auth'], function () {

  Route::group(['middleware' => ['role:Admin|staff']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
        //---------- roles route -------------------
        Route::group(['middleware' => ['role:Admin']], function () {       
            Route::resource('roles', 'RolesController');

        });

    //---------- Cities route -------------------
    Route::resource('cities', 'CitiesController');
    Route::get('get-cities', 'CitiesController@getCities');

    //------------Jobs route -------------------
    Route::resource('jobs', 'JobsController');
    //------------staff route -------------------
    Route::resource('staff', 'StaffController');
    Route::get('staff/{staff}/toggle', 'StaffController@toggleStatus');
    //------------staff route -------------------
    Route::resource('visitors', 'VisitorsController')->except('show');
    Route::get('visitors/{visitor}/toggle', 'VisitorsController@toggleStatus');
    Route::get('visitors/export', 'VisitorsController@exportExcel')->name('visitors.export');
    //------------News route -------------------
    Route::resource('news', 'NewsController');
    Route::get('get-authors', 'NewsController@getAuthors');
    Route::get('news/{news}/toggle', 'NewsController@toggleStatus');

    Route::post('uploads', 'NewsController@uploads')->name('uploads');
    });
});
