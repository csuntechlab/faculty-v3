<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Allows for the formatting of any Model instances that have a "days"
 * attribute.
 */
trait HasDays
{
	/**
     * Returns the set of days as a formatted string.
     *
     * @return string
     */
    public function getFormattedDaysAttribute() {
        if($this->days == 'A') {
            return 'By Arrangement';
        }
        return trim(implode(" ", preg_split('/\s*/', $this->days)));
    }
}