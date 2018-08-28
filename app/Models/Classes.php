<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
	protected $table = 'omar.classes';
    protected $primaryKey = 'classes_id';

    public $incrementing = false;
}
