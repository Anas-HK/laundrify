<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Seller;


class ServiceController extends Controller
{
    public function showService($id)
    {
        $service = Service::find($id);
        if ($service) {
            return view('show', compact('service'));
        } else {
            return redirect()->route('home')->with('error', 'Service not found.');
        }
    }

//     public function showSellerServices($sellerId)
// {
//     $seller = Seller::find($sellerId);
//     $services = Service::where('seller_id', $sellerId)->get();
//     return view('seller-services', compact('seller', 'services'));
// }

// Controller Method

public function showSellerServices($sellerId)
{
    $seller = Seller::find($sellerId);
    $services = $seller->services()->where('is_approved', true)->get(); // Filter services where is_approved is true

    return view('seller-services', compact('seller', 'services'));
}



}
