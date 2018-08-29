<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use CSUNMetaLab\Guzzle\Factories\HandlerGuzzleFactory;

class ProfileController extends Controller
{
    /**
     * The HandlerGuzzle instance.
     *
     * @var HandlerGuzzle
     */
    protected $guzzle;

    /**
     * Constructs a new ProfileController instance.
     */
    public function __construct() {
        parent::__construct();
        $this->guzzle = HandlerGuzzleFactory::fromDefaults();
    }

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

        // add the times_taught and last_taught attributes to each class
        $user->classes = $user->classes->each(function($class) use ($user) {
            $class->times_taught = $user->classes
                ->where('course_id', $class->course_id)
                ->count();
            $class->last_taught = implode(" ", explode("-", $class->term));
        });

        // finally, limit the set of classes to their unique instances based
        // upon course ID since that will be how the timeline is shown
        $user->classes = $user->classes->unique(function($class) {
            return $class->course_id;
        });

        return $user->classes->values();
    }
}
