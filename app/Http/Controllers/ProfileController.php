<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class ProfileController extends Controller
{
	/**
	 * Displays the profile for an individual based on a given URI.
	 *
	 * @param string $uri The URI of the individual
	 */
    public function show($uri) {
    	$user = User::whereUri($uri)
    		->firstOrFail();

    	return view('pages.profile.show', compact('user'));
    }
}
