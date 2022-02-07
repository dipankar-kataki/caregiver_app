<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function covid(){
        return $this->hasMany(Covid::class);
    }

    public function childAbuse(){
        return $this->hasMany(ChildAbuse::class);
    }

    public function criminal(){
        return $this->hasMany(Criminal::class);
    }

    public function driving(){
        return $this->hasMany(Driving::class);
    }

    public function employment(){
        return $this->hasMany(EmploymentEligibility::class);
    }

    public function identification(){
        return $this->hasMany(Identification::class);
    }

    public function tuberculosis(){
        return $this->hasMany(Tuberculosis::class);
    }

    public function w_4_form(){
        return $this->hasMany(w_4_form::class);
    }
}
