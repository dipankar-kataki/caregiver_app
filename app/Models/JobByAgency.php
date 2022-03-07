<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
