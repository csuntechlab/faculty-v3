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
}
