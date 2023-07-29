<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\test_controller;
use App\Http\Controllers\test_vue_js;
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
Route::get('/shotScreen', 'App\Http\Controllers\test_controller@shotScreen');
Route::get('/checkURL', 'App\Http\Controllers\test_controller@checkURL');
Route::get('/scraping', [test_controller::class,'get_total_visit_website']); 

//routes vue
//Route::get('/show', 'App\Http\Controllers\test_vue_js@show');
Route::get('/show',[test_vue_js::class, 'getMessage']);
Route::get('/index', [test_vue_js::class,'index']);
Route::get('/index1', [test_vue_js::class,'index1']);
//Route::get('/scraping', [test_vue_js::class,'scraping']); 