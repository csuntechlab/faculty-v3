<?php

/**
 * Returns an active state if the current URL matches the provided path.
 * Otherwise, this function returns a blank string.
 *
 * @param string $path The partial path to check against the current URL
 * @param string $active Optional parameter to modify the name of the active
 * class that is returned
 *
 * @return string
 */
function setActive($path, $active = 'active') {
    // Allows me to check for an array of paths
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

/**
 * Generates the base URL for the application env value URL. Basically all
 * this does is add a trailing slash if one does not exist.
 *
 * @param string $envUrl The name of the env key to treat as a URL
 * @return string
 */
function generateBaseUrl($envUrl) {
	$base = env($envUrl);
	if(!ends_with($base, '/')) {
		$base .= '/';
	}
	return $base;
}

/**
 * Generates a URL for the Faculty application based upon the URI. The URI
 * should NOT have a leading slash.
 *
 * @param string $uri The URI within the Faculty application to link to
 * @return string
 */
function facultyUrl($uri) {
	$base = generateBaseUrl('FACULTY_APP_URL');
	if($uri == '/') {
		return $base;
	}
	else if(starts_with($uri, '/')) {
		// we may receive something with a leading slash, so take its
		// substring beginning at the second character instead
		$uri = substr($uri, 1);
	}
	return $base . $uri;
}

/**
 * Generates a URL for the HELIX application based upon the URI. The URI
 * should NOT have a leading slash.
 *
 * @param string $uri The URI within the HELIX application to link to
 * @return string
 */
function helixUrl($uri) {
	$base = generateBaseUrl('HELIX_APP_URL');
	if($uri == '/') {
		return $base;
	}
	else if(starts_with($uri, '/')) {
		// we may receive something with a leading slash, so take its
		// substring beginning at the second character instead
		$uri = substr($uri, 1);
	}
	return $base . $uri;
}

/**
 * Generates a URL for the Stories application based upon the URI. The URI
 * should NOT have a leading slash.
 *
 * @param string $uri The URI within the Stories application to link to
 * @return string
 */
function storiesUrl($uri) {
	$base = generateBaseUrl('STORIES_APP_URL');
	if($uri == '/') {
		return $base;
	}
	else if(starts_with($uri, '/')) {
		// we may receive something with a leading slash, so take its
		// substring beginning at the second character instead
		$uri = substr($uri, 1);
	}
	return $base . $uri;
}