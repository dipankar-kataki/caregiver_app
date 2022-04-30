<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaregiverPayment extends Model
{
    use HasFactory;

    protected $table ='caregiver_payments';
    protected $guarded = [];

    public function job(){
        return $this->belongsTo(JobByAgency::class, 'job_id', 'id');
    }
}
