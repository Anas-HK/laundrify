<?php
namespace App\Http\Controllers;
use App\Models\User as AppUser;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Notifications\NewServiceAddedNotification;
use Illuminate\Support\Facades\Storage;


class SellerServiceController extends Controller
{
    public function showAddServiceForm()
    {
        $seller = auth()->guard('seller')->user(); 
        return view('seller.add-service', compact('seller'));
    }




    public function storeService(Request $request)
    {
        // Validation and service creation logic
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
    
        $imagePath = $request->file('image')->store('services', 'public');
    
        $service = Service::create([
            'seller_id' => auth()->guard('seller')->id(),
            'service_name' => $request->service_name,
            'service_description' => $request->service_description,
            'seller_city' => $request->seller_city,
            'seller_area' => $request->seller_area,
            'availability' => $request->availability,
            'service_delivery_time' => $request->service_delivery_time,
            'seller_contact_no' => $request->seller_contact_no,
            'service_price' => $request->service_price,
            'image' => $imagePath,
            'is_approved' => false,
        ]);
    
        $sellerName = auth()->guard('seller')->user()->name;
        $sellerId = auth()->guard('seller')->user()->id;
        $serviceId = $service->id;
        $users = AppUser::all(); 
        foreach ($users as $user) {
            $user->notify(new NewServiceAddedNotification($sellerName, $service->service_name, $sellerId, $serviceId));
        }
    
        return redirect()->route('seller.panel')->with('success', 'Service added successfully and is awaiting admin approval.');
    }
    


public function edit($id)
{
    $service = Service::findOrFail($id);
    if ($service->seller_id != auth()->guard('seller')->id()) {
        abort(403);
    }

    return view('seller.edit-service', compact('service'));
}

public function update(Request $request, $id)
{
    $service = Service::findOrFail($id);
    
    if ($service->seller_id != auth()->guard('seller')->id()) {
        abort(403);
    }

    $validated = $request->validate([
        'service_name' => 'required|string|max:255',
        'service_description' => 'required|string',
        'seller_city' => 'required|string|max:255',
        'seller_area' => 'required|string|max:255',
        'availability' => 'required|string|max:255',
        'service_delivery_time' => 'required|string|max:255',
        'seller_contact_no' => 'required|string|max:255',
        'service_price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($request->hasFile('image')) {
        if ($service->image) {
            Storage::delete('public/' . $service->image);
        }
        
        $validated['image'] = $request->file('image')->store('services', 'public');
    }

    $service->update($validated);

    return redirect()->route('seller.panel')->with('success', 'Service updated successfully');
}

public function delete($id)
{
    $service = Service::findOrFail($id);
    if ($service->seller_id != auth()->guard('seller')->id()) {
        abort(403);
    }

    $service->delete();

    return redirect()->route('seller.panel')->with('success', 'Service deleted successfully!');
}
public function showSellerServices(Seller $seller)
{
    $services = $seller->services()->where('is_approved', true)->get();
    return view('seller-services', compact('seller', 'services'));
}


}
