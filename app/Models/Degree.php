<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
	protected $table = 'degrees';
    protected $primaryKey = 'degrees_id';

    protected $hidden = ['degrees_id', 'user_id'];
}
