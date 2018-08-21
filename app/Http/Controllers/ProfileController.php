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
            // Media WS works based upon redirects to file data but if we allow
            // the redirect to take place then Guzzle will interpret the response
            // as a binary stream
            $this->guzzle->setRequestOption('allow_redirects', false);
            $response = $this->guzzle->get(mediaWsUrl($user->email_uri . '/avatar'));

            // if the response was a redirect, retrieve its Location header
            if($response->hasHeader('Location')) {
                $imageData = $response->getHeader('Location')[0];
            }
            else
            {
                // no Location response so something has probably gone wrong
                // with the Media WS but it wasn't a 500 error; it was probably
                // a JSON response instead
                $imageData = null;
            }
        }
        catch(\Exception $e) {
            // web service probably threw a 500 error
            $imageData = null;
        }

    	return view('pages.profile.show', compact('user', 'imageData'));
    }
}
