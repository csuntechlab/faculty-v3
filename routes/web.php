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
})->name('home');

Route::get('/search', 'SearchController@search')
	->name('search');

Route::get('/departments', 'DepartmentController@all')
	->name('departments');

Route::get('/departments/{id}/faculty', 'DepartmentController@faculty')
	->name('departments.faculty');

	Route::get('/printer-friendly-door-sign', function () {
		return view('pages.printerFriendlyDoorSign');
	})->name('printer-friendly-door-sign');

Route::get('{uri}', 'ProfileController@show')
	->name('profile');