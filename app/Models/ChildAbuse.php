<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildAbuse extends Model
{
    use HasFactory;

    protected $table = 'child_abuses';
    protected $guarded = [];
}
