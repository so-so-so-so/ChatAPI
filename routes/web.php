<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
  return view('chat');
});
Route::post('/post', 'ChatApiController@post');
Route::get('/dlCSV', 'ChatApiController@dlCSV');
Route::post('/delete', 'ChatApiController@delete');
Route::get('/getChat', 'ChatApiController@getChat');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
