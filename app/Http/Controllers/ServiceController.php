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


    public function showSellerServices($sellerId)
    {
        $seller = Seller::find($sellerId);
        $services = $seller->services()->where('is_approved', true)->get(); // Filter services where is_approved is true

        return view('seller-services', compact('seller', 'services'));
    }

public function searchServices(Request $request)
{
    $query = $request->get('q');

    $services = Service::where('service_name', 'like', '%' . $query . '%')
        ->orWhere('service_description', 'like', '%' . $query . '%')
        ->get(['id', 'service_name', 'service_description']); // Return only necessary fields

    return response()->json(['services' => $services]);
}


}
