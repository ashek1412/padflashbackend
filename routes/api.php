<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('getappuser', 'App\Http\Controllers\Api\UserApiController@getuser');
Route::post('checkappuser', 'App\Http\Controllers\Api\UserApiController@checkuser');
Route::post('registerppuser', 'App\Http\Controllers\Api\UserApiController@store');
