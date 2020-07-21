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

Route::post('/search', 'SearchController@index');

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
Route::get('/books/edit/{book}', 'BookController@edit');
Route::get('/books/create', 'BookController@create');
Route::get('/books/{book}', 'BookController@show');
Route::put('/books', 'BookController@store');
Route::patch('/books/edit/{book}', 'BookController@update');
Route::delete('/books/{book}', 'BookController@delete');

/**
 * Review Routes
 */
Route::get('/books/review/{book}', 'ReviewController@create');
Route::put('/books/review', 'ReviewController@store');
Route::get('/books/review/edit/{review}', 'ReviewController@edit');
Route::patch('/books/review/edit/{review}', 'ReviewController@update');
Route::get('/books/{book}/reviews', 'ReviewController@show');

/**
 * Genre Routes
 */
Route::get('/genres', 'GenreController@index');
Route::get('/genres/{link}', 'GenreController@show');

/**
 * Search Routes
 */
Route::get('/authors', 'SearchController@authors');

/**
 * Post Routes
 */
Route::get('/post/', 'PostController@create');
Route::put('/post', 'PostController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
