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
}
