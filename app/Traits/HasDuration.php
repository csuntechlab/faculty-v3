<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Allows for the formatting of any Model instances that have a time duration
 * attribute (start/end times)
 */
trait HasDuration
{
	/**
     * Returns the entity's time duration as a formatted string.
     *
     * @return string
     */
    public function getFormattedDurationAttribute() {
        if($this->location_type == 'online') {
            return 'ONLINE';
        }
        return convertTime($this->start_time) . ' - ' .
            convertTime($this->end_time);
    }

    /**
     * Returns the entity's time duration as a string without formatting.
     */
    public function getDurationAttribute() {
        if($this->location_type == 'online') {
            return 'ONLINE';
        }
        return $this->start_time . ' - ' . $this->end_time;
    }
}