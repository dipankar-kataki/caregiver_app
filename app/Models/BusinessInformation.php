<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessInformation extends Model
{
    use HasFactory;

    protected $table = 'business_information';
    protected $guarded = [];

    public function getBeneficiaryAttribute($value){
        return unserialize($value);
    }

    public function getHomecareServiceAttribute($value){
        return unserialize($value);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
