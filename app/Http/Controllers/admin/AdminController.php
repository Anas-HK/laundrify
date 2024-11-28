<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Models\Service;


class AdminController extends Controller
{

public function view()
{
    $pendingServices = Service::where('is_approved', 0)->get();
    return view('admin.pending-services', compact('pendingServices'));
}
public function approveService($id)
{
    // Find the service by ID
    $service = Service::find($id);
    $service->is_approved = 1; 
    $service->save();

    return redirect()->route('admin.dashboard')->with('status', 'Service approved successfully.');
}
public function approveSeller($id)
    {
        $seller = Seller::find($id);
        $seller->accountIsApproved = 1;
        $seller->save();

        return redirect()->route('admin.dashboard')->with('status', 'Seller approved successfully.');
    }

public function rejectService($id)
{
    $service = Service::find($id);
    $service->delete(); // Alternatively, mark as rejected if needed
    return redirect()->route('admin.dashboard')->with('status', 'Service rejected successfully.');
}

    public function dashboard()
{
    $pendingSellers = Seller::where('accountIsApproved', 0)->where('is_deleted', 0)->get();
    $pendingServices = Service::where('is_approved', 0)->get();

    return view('admin.dashboard', compact('pendingSellers', 'pendingServices'));
}


    

    public function rejectSeller($id)
    {
        $seller = Seller::find($id);
        $seller->is_deleted = 1;
        $seller->save();

        return redirect()->route('admin.dashboard')->with('status', 'Seller rejected and deleted.');
    }
}
