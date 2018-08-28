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

// this route group drives the profile API functionality
Route::prefix('people')->group(function() {
	Route::get('{uri}', 'ProfileController@getMetadata');
	Route::get('{uri}/classes/history', 'ProfileController@getClassHistory');
});