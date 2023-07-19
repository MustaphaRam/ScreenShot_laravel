<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\test_controller;

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

Route::get('/getcapture', 'App\Http\Controllers\test_controller@getCapureByURL');
Route::get('/getcapture1', 'App\Http\Controllers\test_controller@ScreenShot');
Route::get('/index', 'App\Http\Controllers\test_controller@index');
Route::get('/call-node', 'App\Http\Controllers\test_controller@callNodeFunction');
Route::get('/checkURL', 'App\Http\Controllers\test_controller@checkURL');