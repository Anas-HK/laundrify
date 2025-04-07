<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Seller;
use App\Models\Feedback;


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


    public function showSellerServices($seller_id)
    {
        $seller = Seller::findOrFail($seller_id);
        $services = Service::where('seller_id', $seller_id)->get();
        
        // Get feedback for this seller
        $feedbacks = Feedback::where('seller_id', $seller_id)
                      ->with('user')
                      ->get();
        
        return view('seller-services', compact('seller', 'services', 'feedbacks'));
    }

public function searchServices(Request $request)
{
    $query = $request->get('q');

    $services = Service::where('service_name', 'like', '%' . $query . '%')
        ->orWhere('service_description', 'like', '%' . $query . '%')
        ->get(['id', 'service_name', 'service_description']); 

    return response()->json(['services' => $services]);
}


}
