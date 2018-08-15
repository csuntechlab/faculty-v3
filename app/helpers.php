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