<?php

namespace App\Http\Controllers;

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
        // resolve a Guzzle instance
        $this->guzzle = HandlerGuzzleFactory::fromDefaults();
    }

	/**
	 * Displays the profile for an individual based on a given URI.
	 *
	 * @param string $uri The URI of the individual
	 */
    public function show($uri) {
    	$user = User::with('connections', 'departments', 'degrees')
    		->whereUri($uri)
    		->firstOrFail();

        try {
            $response = $this->guzzle->get(mediaWsUrl($user->email_uri . '/avatar'));
            $imageData = $this->guzzle->resolveResponseBody($response);
        }
        catch(\Exception $e) {
            // web service probably threw a 500 error
            $imageData = null;
        }

        // if we got back an object with keys, then we have an issue with the
        // web service
        if(!empty($imageData)) {
            // attempt to resolve the response as JSON and check to see if
            // there is a "success" key in the result; if it's present it
            // means that we got back some kind of JSON error response
            $check = $this->guzzle->resolveResponseBody($response, 'json');
            if(gettype($check) == 'object' && property_exists($check, 'success')) {
                $imageData = null;
            }
            else
            {
                // turn the binary image data into its base64 representation
                $imageData = base64_encode($this->guzzle->resolveResponseBody($response));
            }
        }

    	return view('pages.profile.show', compact('user', 'imageData'));
    }
}
