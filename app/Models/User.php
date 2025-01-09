<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // app/Models/User.php
    protected $fillable = [
        'name',
        'email',
        'password',
        'sellerType',
        'mobile',
        'address',
        'address2',
        'city',
        'state',
        'zip',
        'pickup_time',
        'is_verified',
        'otp'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // In User.php
        public function orders()
        {
            return $this->hasMany(Order::class);
        }

        public function notifications()
        {
            return $this->morphMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable');
        }

}
