<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
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
        'otp',
        'is_suspended',
        'suspended_at',
        'suspension_reason',
        'suspended_by'
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
            'is_suspended' => 'boolean',
            'suspended_at' => 'datetime',
        ];
    }
        public function orders()
        {
            return $this->hasMany(Order::class);
        }

        public function notifications()
        {
            return $this->morphMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable');
        }

        /**
         * Get the favorites for the user.
         */
        public function favorites()
        {
            return $this->hasMany(Favorite::class);
        }
        
        /**
         * Get the favorited services for the user.
         */
        public function favoritedServices()
        {
            return $this->belongsToMany(Service::class, 'favorites', 'user_id', 'service_id')->withTimestamps();
        }

        /**
         * Get the admin who suspended this user.
         */
        public function suspendedBy()
        {
            return $this->belongsTo(User::class, 'suspended_by');
        }
        
        /**
         * Check if the user's account is suspended.
         *
         * @return bool
         */
        public function isSuspended(): bool
        {
            return $this->is_suspended;
        }
        
        /**
         * Scope a query to only include active users.
         *
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function scopeActive(Builder $query): Builder
        {
            return $query->where('is_suspended', false);
        }
        
        /**
         * Scope a query to only include suspended users.
         *
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function scopeSuspended(Builder $query): Builder
        {
            return $query->where('is_suspended', true);
        }

}
