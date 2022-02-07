<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuberculosis extends Model
{
    use HasFactory;

    protected $table = 'tuberculoses';
    protected $guarded = [];
}
