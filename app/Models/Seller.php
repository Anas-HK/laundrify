<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class Seller extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'city',
        'area',
        'accountIsApproved',
        'is_deleted',
        'is_suspended',
        'suspended_at',
        'suspension_reason',
        'suspended_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_suspended' => 'boolean',
        'suspended_at' => 'datetime',
    ];

    // Mutator to hash passwords only if they aren't already hashed
    public function setPasswordAttribute($password)
    {
        // Only hash if the password isn't already hashed (Hash::needsRehash)
        if (Hash::needsRehash($password)) {
            $this->attributes['password'] = Hash::make($password);
        } else {
            $this->attributes['password'] = $password;
        }
    }

    // Relationship with the Service model
    public function services()
    {
        return $this->hasMany(Service::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable');
    }

    /**
     * Get the seller's verification request.
     */
    public function verificationRequest()
    {
        return $this->hasOne(SellerVerification::class);
    }

    /**
     * Check if the seller is verified.
     *
     * @return bool
     */
    public function isVerified()
    {
        return $this->verificationRequest && $this->verificationRequest->status === 'approved';
    }

    /**
     * Get the admin who suspended this seller.
     */
    public function suspendedBy()
    {
        return $this->belongsTo(User::class, 'suspended_by');
    }
    
    /**
     * Check if the seller's account is suspended.
     *
     * @return bool
     */
    public function isSuspended(): bool
    {
        return $this->is_suspended;
    }
    
    /**
     * Scope a query to only include active sellers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_suspended', false);
    }
    
    /**
     * Scope a query to only include suspended sellers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSuspended(Builder $query): Builder
    {
        return $query->where('is_suspended', true);
    }
}
