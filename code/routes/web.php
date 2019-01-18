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

Route::get('/', function () {
    return view('dashboard');
});
Route::get('dashboard', function () {
    return view('dashboard');
});

Route::get('login','AuthController@login');
Route::post('login','AuthController@login_proses');
Route::post('logout','AuthController@logout');
