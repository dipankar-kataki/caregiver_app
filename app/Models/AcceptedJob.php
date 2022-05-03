<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcceptedJob extends Model
{
    use HasFactory;

    protected $table = 'accepted_jobs';
    protected $guarded = [];

    public function jobByAgency(){
        return $this->belongsTo(JobByAgency::class, 'job_by_agencies_id', 'id');
    }

    public function caregiver(){
        return $this->belongsTo(User::class, 'caregiver_id', 'id');
    }

    public function agency(){
        return $this->belongsTo(User::class, 'agency_id', 'id');
    }

    public function profile(){
        return $this->belongsTo(Registration::class, 'caregiver_id', 'user_id');
    }

    public function caregiver_payment(){
        return $this->hasMany(CaregiverPayment::class,  'job_id', 'job_by_agencies_id');
    }

    public function agency_profile(){
        return $this->belongsTo(BusinessInformation::class,'agency_id', 'user_id');
    }
}
