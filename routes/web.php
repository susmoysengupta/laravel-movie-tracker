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

Route::get('/', 'MovieController@index')->name('movies.index');
Route::get('/movie/{movie}', 'MovieController@show')->name('movies.show');

Route::get('/actors', 'ActorsController@index')->name('actors.index');
Route::get('/actors/page/{page}', 'ActorsController@index');
Route::get('/actors/{actor}', 'ActorsController@show')->name('actors.show');
