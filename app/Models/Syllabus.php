<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model {
	use HasCompositePrimaryKey;

	protected $table = 'syllabi';
	protected $primaryKey = ['user_id', 'classes_id'];

	protected $appends = ['syllabus_profile_url'];

	public $incrementing = false;

    /**
     * Creates the syllabus url to display on the
     * front-end
     *
     * @return string
     */
    public function getSyllabusProfileUrlAttribute()
    {
        if (env('AWS_CDN_URL')) {
            return env('AWS_CDN_URL').config('app.syllabus_upload_location').$this->term.'/'.$this->syllabus_url;
        }

        return asset(config('app.syllabus_upload_location').$this->term.'/'.$this->syllabus_url);
    }
}
