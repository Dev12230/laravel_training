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
            Route::PATCH('/staff/{id}/toggle', 'StatusController@update');
            Route::get('/get-staff', 'StaffController@getStaff')->name('get-staff');
        //------------staff route -------------------
            Route::resource('visitors', 'VisitorsController')->except('show');
            Route::PATCH('/visitors/{id}/toggle', 'StatusController@update');
        //------------News route -------------------
            Route::resource('news', 'NewsController');
            Route::get('get-authors', 'NewsController@getAuthors');
            Route::get('get-published', 'NewsController@getPublishedNews');
            Route::PATCH('/news/{id}/toggle', 'StatusController@update');

            Route::post('uploads', 'NewsController@uploads')->name('uploads');
        //------------Images route -------------------
            Route::post('{model}/image', 'ImagesController@store')->name('store-Image');
            Route::get('delete-image/{id}', 'ImagesController@destroy')->name('deleteImage');
            Route::post('{model}/get-images', 'ImagesController@getImages')->name('getImages');
            Route::POST('upload-Folder-Image/{folder}', 'ImagesController@uploadImageForFolder')->name('ImageFolder');
        //------------Files route -------------------
            Route::post('{model}/file', 'FilesController@store')->name('store-File');
            Route::get('delete-file/{id}', 'FilesController@destroy')->name('deleteFile');
            Route::post('{model}/get-files', 'FilesController@getFiles')->name('getFiles');
            Route::POST('upload-Folder-File/{folder}', 'FilesController@uploadFileForFolder')->name('FileFolder');
        //------------videos route -------------------
            Route::POST('upload-Folder-Video/{folder}', 'VideosController@uploadVideoForFolder')->name('VideoFolder');
        //------------Events route -------------------
            Route::resource('events', 'EventsController');
            Route::get('get-visitors', 'EventsController@getVisitors');
        //------------Library route -------------------
            Route::resource('folders', 'FoldersController');   
        });
    });
