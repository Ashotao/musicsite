<?php

use Illuminate\Support\Facades\Route;

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
Route::post('/auth/register', 'Auth\RegisterController@register');
Route::post('/auth/login', 'Auth\LoginController@login');
Route::post('/addsong', 'Api\SongController@addSong');

Route::get('/auth/logout', 'Auth\LoginController@logout');
Route::get('/', 'MainController@index');
Route::get('/{any}', 'MainController@index')->where('any', 'auth/login|auth/register|music');
