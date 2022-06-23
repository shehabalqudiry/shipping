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

    public $guarded = [];

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

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function ACCOUNT_NUMBER()
    {
        $number = Setting::first()->first_char_account_number . '-' . $this->account_number;
        return $number;
    }
}
