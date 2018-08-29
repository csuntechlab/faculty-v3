<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassMeeting extends Model
{
	protected $table = 'omar.classMeetings';
    protected $primaryKey = 'classes_id';

    protected $appends = ['formatted_days', 'formatted_duration'];

    public $incrementing = false;
    protected $hidden = [
        'classes_id',
        'term_id',
        'term',
        'class_number'
    ];

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

    /**
     * Returns the class' time duration as a formatted string.
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
}
