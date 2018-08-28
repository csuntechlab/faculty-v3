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
     * @return User
	 */
    public function getMetadata($uri) {
    	$user = User::with('connections', 'departments', 'degrees')
    		->whereUri($uri)
    		->firstOrFail();

        if($user->primary_connection) {
            $user->primary_connection->pivot->formatted_telephone =
                formatPhoneNumber($user->primary_connection->pivot->telephone);
        }

    	return $user;
    }

    /**
     * Returns the set of all classes the individual identified by the URI
     * has ever taught at the university.
     *
     * @param string $uri The URI of the individual
     * @return JSON
     */
    public function getClassHistory($uri) {
        $user = User::with('classes')
            ->whereUri($uri)
            ->firstOrFail();

        // reject any classes with a non-numeric designation since we use
        // those for special cases and they're non-academic
        $user->classes = $user->classes->reject(function($class) {
            return !preg_match('/^[0-9]+$/', $class->class_number);
        });

        // finally, limit the set of classes to their unique instances based
        // upon course ID since that will be how the timeline is shown
        $user->classes = $user->classes->unique(function($class) {
            return $class->course_id;
        });

        return $user->classes->values();
    }
}
