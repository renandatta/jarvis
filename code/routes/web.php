<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('storage/{folder}/{filename}', function ($folder,$filename){
    $path = storage_path('app/' . $folder . '/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});


Route::get('/','HomeController@dashboard');

Route::get('login','AuthController@login');
Route::post('login','AuthController@login_proses');
Route::post('logout','AuthController@logout');

Route::group(['middleware' => ['check_login']],function(){
    Route::get('user_level/{search?}','UserLevelController@index');
    Route::post('user_level/search','UserLevelController@search');
    Route::get('user_level/info/{id}','UserLevelController@info');
    Route::post('user_level/save/{id}','UserLevelController@save');
    Route::delete('user_level/delete/{id}','UserLevelController@delete');

    Route::get('user/{search?}','UserController@index');
    Route::post('user/search','UserController@search');
    Route::get('user/info/{id}','UserController@info');
    Route::post('user/save/{id}','UserController@save');
    Route::delete('user/delete/{id}','UserController@delete');

    Route::get('user_log/{user_id?}/{search?}','UserLogController@index');
    Route::post('user_log/search','UserLogController@search');

    Route::get('client_type/{search?}','ClientTypeController@index');
    Route::post('client_type/search','ClientTypeController@search');
    Route::get('client_type/info/{id}','ClientTypeController@info');
    Route::post('client_type/save/{id}','ClientTypeController@save');
    Route::delete('client_type/delete/{id}','ClientTypeController@delete');

    Route::get('location/{search?}','LocationController@index');
    Route::post('location/search','LocationController@search');
    Route::get('location/info/{id}','LocationController@info');
    Route::post('location/save/{id}','LocationController@save');
    Route::delete('location/delete/{id}','LocationController@delete');

    Route::get('team/{search?}','TeamController@index');
    Route::post('team/search','TeamController@search');
    Route::get('team/info/{id}','TeamController@info');
    Route::post('team/save/{id}','TeamController@save');
    Route::delete('team/delete/{id}','TeamController@delete');

    Route::get('client/{search?}','ClientController@index');
    Route::post('client/search','ClientController@search');
    Route::get('client/info/{id}','ClientController@info');
    Route::post('client/save/{id}','ClientController@save');
    Route::delete('client/delete/{id}','ClientController@delete');

    Route::get('project/{search?}','ProjectController@index');
    Route::post('project/search','ProjectController@search');
    Route::get('project/attachment/{id}','ProjectController@attachment');
    Route::get('project/info/{id}','ProjectController@info');
    Route::post('project/save/{id}','ProjectController@save');
    Route::post('project/attachment/{id}','ProjectController@save_attachment');
    Route::delete('project/delete/{id}','ProjectController@delete');
    Route::delete('project/attachment/{id}','ProjectController@delete_attachment');
});