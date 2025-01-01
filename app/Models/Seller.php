<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Mutator to automatically hash passwords
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
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

}
