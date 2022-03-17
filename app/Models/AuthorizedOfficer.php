<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AuthorizedOfficer extends Model
{
    use HasFactory;

    protected $table = 'authorized_officers';
    protected $guarded = [];

    public function getDobAttribute($value){
        return Carbon::parse($value)->format('m-d-Y');
    }
}
