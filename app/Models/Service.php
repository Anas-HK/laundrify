<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'service_name',
        'service_description',
        'seller_city',
        'seller_area',
        'availability',
        'service_delivery_time',
        'seller_contact_no',
        'service_price',
        'image',
    ];
    
    // Service.php
public function seller()
{
    return $this->belongsTo(Seller::class, 'seller_id');
}

}
