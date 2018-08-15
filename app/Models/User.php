<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id';

    // this must be set for models that do not use an auto-incrementing PK
    public $incrementing = false;

    /**
     * Retrieves a BelongsToMany representing the set of AcademicDepartment instances 
     * associated with this user. This only retrieves active instances.
     *
     * @return BelongsToMany
     */
    public function departments() {
    	return $this->belongsToMany('App\Models\AcademicDepartment', 'department_user', 'user_id', 'department_id')
    		->withPivot('primary', 'role_name')
    		->wherePivot('status', 'Active')
    		->wherePivot('confidential', 0);
    }

    /**
     * Scopes the query to a specific URI. Currently this is the email address
     * but this method can be modified in the future to retrieve a URI from
     * a different source.
     *
     * @param Builder $query The query to constrain
     * @param string $uri The URI to look-up
     *
     * @return Builder
     */
    public function scopeWhereUri($query, $uri) {
    	return $query->where('email', 'LIKE', $uri . '@%csun.edu');
    }

    /**
     * Returns an instance of the primary department for an individual.
     *
     * @return Department|null
     */
    public function getPrimaryDepartmentAttribute() {
    	if(!empty($this->departments)) {
    		// check whether a primary department exists
    		$primary = $this->departments->filter(function($dept) {
    			return (boolean)$dept->pivot->primary;
    		})->first();

    		if(!empty($primary)) {
    			return $primary;
    		}

    		// just return the first department if nothing is marked as
    		// the primary department
    		return $this->departments->first();
    	}
    	return null;
    }
}
