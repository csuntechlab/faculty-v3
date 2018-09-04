<?php

namespace App\Models;

use App\Traits\HasDays;
use App\Traits\HasDuration;

use Illuminate\Database\Eloquent\Model;

class ClassMeeting extends Model
{
    use HasDays;
    use HasDuration;

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
}
