<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Term;
use App\Models\User;

class ProfileController extends Controller
{
	/**
	 * Displays the profile for an individual based on a given URI.
	 *
	 * @param string $uri The URI of the individual
	 */
    public function show($uri) {
    	$user = User::with('connections', 'departments', 'degrees')
    		->whereUri($uri)
    		->firstOrFail();

        $currentTerm = Term::current();

    	return view('pages.profile.show', compact('user', 'currentTerm'));
    }
}
