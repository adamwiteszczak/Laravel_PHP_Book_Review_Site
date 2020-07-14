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

Route::get('/', function () {
    return view('welcome');
});

/**
 * Profile Routes
 */
Route::get('/profile', 'ProfileController@index');
Route::get('/profile/edit', 'ProfileController@edit');
Route::get('/profile/{link}', 'ProfileController@show');
Route::patch('/profile', 'ProfileController@update')->name('profile.update');

/**
 * Follow Routes
 */
Route::post('/follow/{user}', 'FollowsController@store');

/**
 * Book Routes
 */
Route::get('/books/create', 'BookController@create');
Route::get('/books/{book}','BookController@show');
Route::put('/books', 'BookController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
