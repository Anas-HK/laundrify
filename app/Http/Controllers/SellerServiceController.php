<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class SellerServiceController extends Controller
{
    public function showAddServiceForm()
    {
        $seller = auth()->guard('seller')->user(); // Get the logged-in seller
        return view('seller.add-service', compact('seller'));
    }

    public function storeService(Request $request)
{
    $request->validate([
        'service_name' => 'required|string|max:255',
        'service_description' => 'required|string',
        'seller_city' => 'required|string',
        'seller_area' => 'required|string',
        'availability' => 'required|string',
        'service_delivery_time' => 'required|string',
        'seller_contact_no' => 'required|string|max:15',
        'service_price' => 'required|numeric',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Store the image and get the path
    $imagePath = $request->file('image')->store('services', 'public');

    // Create the service with approval status set to false
    Service::create([
        'seller_id' => auth()->guard('seller')->id(), // Assuming 'seller' guard is used
        'service_name' => $request->service_name,
        'service_description' => $request->service_description,
        'seller_city' => $request->seller_city,
        'seller_area' => $request->seller_area,
        'availability' => $request->availability,
        'service_delivery_time' => $request->service_delivery_time,
        'seller_contact_no' => $request->seller_contact_no,
        'service_price' => $request->service_price,
        'image' => $imagePath,
        'is_approved' => false, // Default to not approved
    ]);

    return redirect()->route('seller.panel')->with('success', 'Service added successfully and is awaiting admin approval.');
}

    public function edit($id)
{
    $service = Service::findOrFail($id);
    // Ensure the seller is the owner of this service
    if ($service->seller_id != auth()->guard('seller')->id()) {
        abort(403);
    }

    return view('seller.edit-service', compact('service'));
}

public function delete($id)
{
    $service = Service::findOrFail($id);
    // Ensure the seller is the owner of this service
    if ($service->seller_id != auth()->guard('seller')->id()) {
        abort(403);
    }

    $service->delete();

    return redirect()->route('seller.panel')->with('success', 'Service deleted successfully!');
}

}
