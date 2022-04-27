<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaregiverBankAccount extends Model
{
    use HasFactory;

    protected $table = 'caregiver_bank_accounts';
    protected $guarded = [];
}
