<?php

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
    return view('pages.index');
});

Route::get('/search', function () {
    return view('pages.search-results');
});

Route::get('/departments', function () {
    return view('pages.departments');
});

Route::get('{uri}', 'ProfileController@show');