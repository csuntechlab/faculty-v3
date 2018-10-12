<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	protected $table = 'departments';
    protected $primaryKey = 'department_id';

    public $incrementing = false;

    /**
     * Returns a BelongsToMany representing the set of active faculty members
     * in this department.
     *
     * @return BelongsToMany
     */
    public function faculty() {
    	return $this->belongsToMany('App\Models\User', 'department_user', 'department_id', 'user_id')
			->wherePivotIn('role_name', ['faculty', 'emeritus']);
    		//->wherePivot('status', 'Active');
    }
}
