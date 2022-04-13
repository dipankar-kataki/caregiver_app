<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildAbuse extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'child_abuses';
    protected $guarded = [];
}
