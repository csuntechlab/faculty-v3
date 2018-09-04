<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use App\Traits\HasDays;
use App\Traits\HasDuration;

use Illuminate\Database\Eloquent\Model;

class OfficeHour extends Model
{
	use HasCompositePrimaryKey;
	use HasDays;
	use HasDuration;

	protected $table = 'officehours';
    protected $primaryKey = ['individuals_id', 'term_id', 'meeting_number'];

    protected $appends = ['formatted_days', 'appointment_only', 'duration'];

    public $incrementing = false;

    /**
     * Returns whether this OfficeHour instance is by appointment ONLY.
     *
     * @return bool
     */
    public function getAppointmentOnlyAttribute() {
    	return $this->is_byappointment && !$this->is_walkin;
    }
}
