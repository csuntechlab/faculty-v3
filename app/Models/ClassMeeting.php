<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassMeeting extends Model
{
	protected $table = 'omar.classMeetings';
    protected $primaryKey = 'classes_id';

    public $incrementing = false;
    protected $hidden = [
        'classes_id',
        'term_id',
        'term',
        'class_number'
    ];
}
