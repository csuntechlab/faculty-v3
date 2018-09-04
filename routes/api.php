<?php

use Illuminate\Http\Request;

// All routes in this file use the controller(s) under the
// App\Http\Controllers\Api namespace. This namespace is set
// in the RouteServiceProvider class.

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// this route group drives the person-based profile API functionality
Route::prefix('people')->group(function() {
	Route::get('{uri}', 'ProfileController@getMetadata');
	Route::get('{uri}/classes', 'ProfileController@getClasses');
	Route::get('{uri}/classes/history', 'ProfileController@getClassHistory');
	Route::get('{uri}/office-hours', 'ProfileController@getOfficeHours');
});

// this route group drives any arbitrary collection-based functionality
Route::prefix('collections')->group(function() {
	// this route retrieves both the collection of terms and the current term
	// so it can populate drop-down fields
	Route::get('terms', 'TermController@getTerms');
});