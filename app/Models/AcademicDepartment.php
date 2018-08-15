<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicDepartment extends Model
{
	protected $table = 'departments';
    protected $primaryKey = 'department_id';

    // this must be set for models that do not use an auto-incrementing PK
    public $incrementing = false;
}
