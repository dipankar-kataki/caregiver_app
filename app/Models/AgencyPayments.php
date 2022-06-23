<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyPayments extends Model
{
    use HasFactory;

    protected $table = 'agency_payments';
    protected $guarded = [];


    public function user(){
        return $this->belongsTo(User::class, 'agency_id', 'id');
    }

    public function job(){
        return $this->belongsTo(JobByAgency::class, 'job_id', 'id')->withTrashed();
    }
}
