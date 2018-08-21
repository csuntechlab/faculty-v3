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
     * Retrieves a BelongsToMany representing the set of Connectable instances
     * associated with this user. This only retrieves instances that should
     * be displayed.
     *
     * @return BelongsToMany
     */
    public function connections() {
        return $this->belongsToMany('App\Models\Connectable', 'contacts', 'user_id', 'connectable_id')
            ->withPivot(
                'role_position', 'precedence', 'title', 'email', 'telephone',
                'facsimile_telephone', 'website', 'location', 'office', 'mail_drop'
            )
            ->wherePivot('is_displayed', 1);
    }

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
     * Retrieves a HasMany representing the set of Degree instances associated with
     * this user.
     *
     * @return HasMany
     */
    public function degrees() {
        return $this->hasMany('App\Models\Degree', 'user_id');
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
     * Returns whether this individual has graduated from CSUN at some point.
     *
     * @return bool
     */
    public function getIsCsunAlumAttribute() {
        if(!isset($this->degrees)) {
            $this->load('degrees');
        }

        $institutes = [
            'csun',
            'cal state northridge',
            'cal state university northridge',
            'cal state university, northridge',
            'california state university northridge',
            'california state univeristy, northridge'
        ];

        $degrees = $this->degrees->filter(function($degree) use ($institutes) {
            return in_array(strtolower($degree->institute), $institutes);
        });
        return ($degrees->count() > 0);
    }

    /**
     * Retrieves the part of the email address before the @ symbol.
     *
     * @return string
     */
    public function getEmailUriAttribute() {
        $parts = explode('@', $this->email);
        return $parts[0];
    }

    /**
     * Returns an instance of the primary connection for an individual.
     *
     * @return Connectable|null
     */
    public function getPrimaryConnectionAttribute() {
        if(!isset($this->connections)) {
            $this->load('connections');
        }

        if($this->connections->count() == 0) {
            return null;
        }

        // sort the connections in ascending order by precedence
        $connections = $this->connections->sortBy(function($connection) {
            return $connection->pivot->precedence;
        })->values();

        return $connections->first();
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
