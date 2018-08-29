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
 * Generates a URL for the Bookstore servlet resource based upon the set of
 * function parameters.
 *
 * @param int $term_id The numeric term ID
 * @param string $subject_code The catalog subject code (i.e. COMP)
 * @param string $catalog_number The catalog number (i.e. 484)
 * @param int $class_number The ticket number of the class
 *
 * @return string
 */
function bookstoreUrl($term_id, $subject_code, $catalog_number, $class_number) {
	$base = env("BOOKSTORE_URL"); // we do not want a trailing slash

	return $base . '?' .
		'bookstore_id-1=' . env('BOOKSTORE_ID') . '&' .
		'term_id-1=' . $term_id . '&' .
		'div-1=&' .
		'dept-1=' . $subject_code . '&' .
		'course-1=' . $catalog_number . '&' .
		'section-1=' . $class_number;
}

/**
 * Generates a URL for the Curriculum web service based upon the URI. The URI
 * should NOT have a leading slash.
 *
 * @param string $uri The URI within the Curriculum WS to link to
 * @return string
 */
function curriculumWsUrl($uri) {
	$base = generateBaseUrl('CURRICULUM_WEB_SERVICE');
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
 * Generates a URL for the Media Web Service based upon the URI. The URI
 * should NOT have a leading slash.
 *
 * @param string $uri The URI within the Media web service to link to
 * @return string
 */
function mediaWsUrl($uri) {
	$base = generateBaseUrl('MEDIA_WEB_SERVICE');
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

/**
 * Returns a formatted string taking a phone-like string parameter containing
 * ten digits. If the parameter is empty this method does nothing and just
 * returns the parameter back. If the parameter does not have ten characters
 * this method will just return the parameter back.
 *
 * @param string $phone The ten-digit phone-like string
 * @return string
 */
function formatPhoneNumber($phone) {
    if(empty($phone)) return $phone;
    if(strlen($phone) != 10) return $phone;

    // first rip out any non-phone characters to be safe; this will take care
    // of any potential case where phone numbers come in that were not entered
    // through the Faculty application
    $phone = preg_replace('/[^A-Z0-9]/', '', $phone);

    // grab the area code and the relevant digits
    $areaCode = substr($phone, 0, 3);
    $centralOfficeCode = substr($phone, 3, 3);
    $lineNumber = substr($phone, 6, 4);

    // format and return
    return "{$areaCode}-{$centralOfficeCode}-{$lineNumber}";
}