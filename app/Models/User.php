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

    protected $hidden = ['user_id', 'created_at', 'updated_at', 'connections', 'departments'];
    protected $appends = [
        'is_csun_alum',
        'primary_connection',
        'primary_department',
        'uri'
    ];

    /**
     * Retrieves a BelongsToMany representing the set of Classes instances
     * associated with this user. This only retrieves instances where the
     * user has an active designation.
     *
     * @return BelongsToMany
     */
    public function classes() {
        return $this->belongsToMany('App\Models\Classes', 'nemo.classInstructors', 'members_id', 'classes_id')
            ->wherePivot('member_status', 'Active')
            ->orderBy('term_id', 'DESC');
    }

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
        return $this->hasMany('App\Models\Degree', 'user_id')
            ->orderBy('year', 'DESC');
    }

    /**
     * Retrieves a HasMany representing the set of OfficeHour instances associated
     * with this user.
     *
     * @return HasMany
     */
    public function officeHours() {
        return $this->hasMany('App\Models\OfficeHour', 'user_id');
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
     * Scopes the query only to active individuals.
     *
     * @param Builder $query The query to constrain
     * @return Builder
     */
    public function scopeWhereActive($query) {
        return $query->where('affiliation_status', 'Active');
    }

    /**
     * Scopes the query only to faculty members.
     *
     * @param Builder $query The query to constrain
     * @return Builder
     */
    public function scopeWhereFaculty($query) {
        return $query->whereNotNull('rank');
    }

    /**
     * Scopes the query only to individuals that are alive.
     *
     * @param Builder $query The query to constrain
     * @return Builder
     */
    public function scopeWhereNotDeceased($query) {
        return $query->where('deceased', '0');
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
        $email = $this->email;
        if(app()->environment() == 'production') {
            if(starts_with($email, 'nr_')) {
                $email = substr($email, 3);
            }
        }

        $parts = explode('@', $email);
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
     * Returns the display line for the primary connection (name + title). The
     * returned string is different based upon the following conditions:
     *
     * 1) If the primary connection is different than the primary department:
     *    - Add the name of the primary connection to the line
     *    1a) If the title of the primary connection is different than the rank:
     *        - Add a dash followed by the title of the connection
     * 2) The primary connection and primary department are the same:
     *    - Add the title of the primary connection if it differs from the rank
     *
     * @return string
     */
    public function getPrimaryConnectionLineAttribute() {
        $line = "";
        if(!isset($this->connections)) {
            $this->load('connections');
        }

        if(!isset($this->departments)) {
            $this->load('departments');
        }

        if(!$this->primary_connection) {
            return "";
        }
        if(!$this->primary_department) {
            return "";
        }

        if($this->primary_connection->connectable_id != $this->primary_department->department_id) {
            $line .= $this->primary_connection->name;
            if($this->primary_connection->pivot->title != $this->rank) {
                $line .= ' - ' . $this->primary_connection->pivot->title;
            }
        }
        else
        {
            if($this->primary_connection->pivot->title != $this->rank) {
                $line = $this->primary_connection->pivot->title;
            }
        }

        return $line;
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

    /**
     * Returns the URI for this user. Currently this is the email address
     * but this method can be modified in the future to retrieve a URI from
     * a different source.
     */
    public function getUriAttribute() {
        return $this->email_uri;
    }
}
