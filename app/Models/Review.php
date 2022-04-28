<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table="reviews";
    protected $guarded = [];

    public function caregiver(){
        return $this->belongsTo(User::class, 'caregiver_id', 'id');
    }

    public function agency(){
        return $this->belongsTo(User::class, 'agency_id', 'id');
    }

    public function profile(){
        return $this->belongsTo(Registration::class, 'caregiver_id', 'user_id');
    }

    public function business_information(){
        return $this->belongsTo(BusinessInformation::class, 'agency_id', 'user_id');
    }
}
