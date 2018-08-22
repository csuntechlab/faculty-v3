<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ProfileController extends Controller
{
	/**
	 * Returns the metadata for an individual based on a given URI.
	 *
	 * @param string $uri The URI of the individual
	 */
    public function getMetadata($uri) {
    	$user = User::with('connections', 'departments', 'degrees')
    		->whereUri($uri)
    		->firstOrFail();

    	return $user;
    }
}
