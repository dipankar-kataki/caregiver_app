<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class w_4_form extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'w_4_forms';
    protected $guarded = [];
}
