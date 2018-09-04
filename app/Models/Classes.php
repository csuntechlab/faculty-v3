<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
	protected $table = 'omar.classes';
    protected $primaryKey = 'classes_id';

    public $incrementing = false;

    /**
     * Returns a HasMany representing the set of all ClassMeeting instances
     * associated with this Classes instance.
     *
     * @return HasMany
     */
    public function classMeetings() {
    	return $this->hasMany('App\Models\ClassMeeting', 'classes_id')
    		->orderBy('meeting_number', 'ASC');
    }

    /**
     * Returns a HasMany representing the set of all Syllabus instances
     * associated with this Classes instance.
     *
     * @return HasMany
     */
    public function syllabi() {
    	return $this->hasMany('App\Models\Syllabus', 'classes_id');
    }
}
