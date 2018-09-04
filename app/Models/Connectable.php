<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connectable extends Model
{
	protected $table = 'connectable';
    protected $primaryKey = 'connectable_id';

    public $incrementing = false;
}
