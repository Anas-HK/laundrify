<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;



class AdminController extends Controller
{

public function view()
{
    $pendingServices = Service::where('is_approved', 0)->get();
    return view('admin.pending-services', compact('pendingServices'));
}
public function approveService($id)
{
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
    $sellers = Seller::where('accountIsApproved', 1)->where('is_deleted', 0)->get();

    return view('admin.dashboard', compact('pendingSellers', 'pendingServices', 'sellers'));
}
public function manageSellers()
    {
        $sellers = Seller::paginate(10);
        return view('admin.sellers', compact('sellers'));
    }

    public function manageServices()
    {
        $services = Service::paginate(10);
        return view('admin.services', compact('services'));
    }

    public function settings()
    {
        return view('admin.settings');
    }
    public function rejectSeller($id)
    {
        $seller = Seller::find($id);
        $seller->is_deleted = 1;
        $seller->save();

        return redirect()->route('admin.dashboard')->with('status', 'Seller rejected and deleted.');
    }

    public function loginAsSeller($id)
    {
        // Store admin's ID in session before switching
        session(['admin_id' => Auth::id()]);
        
        $seller = Seller::find($id);
        if ($seller) {
            Auth::guard('seller')->login($seller);
            return redirect()->route('seller.panel');
        }
        return redirect()->back()->with('error', 'Seller not found');
    }

    public function returnToAdmin()
    {
        // Get stored admin ID
        $adminId = session('admin_id');
        
        // Logout from seller
        Auth::guard('seller')->logout();
        
        // Login as admin
        Auth::loginUsingId($adminId);
        
        // Clear the stored admin ID
        session()->forget('admin_id');
        
        return redirect()->route('admin.dashboard');
    }
}
