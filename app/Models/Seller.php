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
        'accountIsApproved',
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
    public function services()
{
    return $this->hasMany(Service::class);
}
}
