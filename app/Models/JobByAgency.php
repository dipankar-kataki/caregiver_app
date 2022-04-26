<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JobByAgency extends Model
{
    use HasFactory;

    protected $table = 'job_by_agencies';
    protected $guarded = [];
    public function getMedicalHistoryAttribute($value){
        return unserialize($value);
    }
    public function getEssentialPriorExpertiseAttribute($value){
        return unserialize($value);
    }
    public function getOtherRequirementsAttribute($value){
        return unserialize($value);
    }

    public function getStartDateOfCareAttribute($value){
        return Carbon::parse($value)->format('m-d-Y');
    }
    public function getEndDateOfCareAttribute($value){
        return Carbon::parse($value)->format('m-d-Y');
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id' );
    }

    public function payment_status(){
        return $this->hasMany(AgencyPayments::class, 'job_id', 'id');
    }

  
}
