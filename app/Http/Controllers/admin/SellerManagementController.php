<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerManagementController extends Controller
{
    /**
     * Check if the user has admin access.
     *
     * @return \Illuminate\Http\RedirectResponse|null
     */
    private function checkAdminAccess()
    {
        if (!Auth::check() || Auth::user()->sellerType != 1) {
            return redirect('/')->with('error', 'You do not have admin access.');
        }
        
        return null;
    }

    /**
     * Display a listing of the sellers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Check admin access
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $filter = $request->get('filter', 'all');
        
        $query = Seller::query();
        
        // Apply filters
        if ($filter === 'active') {
            $query->active();
        } elseif ($filter === 'suspended') {
            $query->suspended();
        }
        
        // Apply search if provided
        if ($request->has('search')) {
            $searchTerm = $request->get('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }
        
        $sellers = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.sellers.index', [
            'sellers' => $sellers,
            'filter' => $filter,
            'search' => $request->get('search', '')
        ]);
    }
    
    /**
     * Display the specified seller.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\View\View
     */
    public function show(Seller $seller)
    {
        // Check admin access
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        // Load orders and other relevant info
        $seller->load(['orders' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }]);
        
        // Get suspension history if applicable
        $suspensionInfo = null;
        if ($seller->isSuspended()) {
            $suspensionInfo = [
                'suspended_at' => $seller->suspended_at,
                'suspension_reason' => $seller->suspension_reason,
                'suspended_by' => $seller->suspendedBy ? $seller->suspendedBy->name : 'Unknown Admin'
            ];
        }
        
        return view('admin.sellers.show', [
            'seller' => $seller,
            'suspensionInfo' => $suspensionInfo
        ]);
    }
    
    /**
     * Suspend a seller account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\RedirectResponse
     */
    public function suspend(Request $request, Seller $seller)
    {
        // Check admin access
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $request->validate([
            'reason' => 'required|string|min:5|max:500',
        ]);
        
        // Don't suspend already suspended sellers
        if ($seller->isSuspended()) {
            return redirect()->back()->with('error', 'This seller is already suspended.');
        }
        
        // Update seller record
        $seller->update([
            'is_suspended' => true,
            'suspended_at' => now(),
            'suspension_reason' => $request->reason,
            'suspended_by' => Auth::id()
        ]);
        
        return redirect()->route('admin.sellers.show', $seller)
            ->with('success', 'Seller account has been suspended successfully.');
    }
    
    /**
     * Unsuspend a seller account.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsuspend(Seller $seller)
    {
        // Check admin access
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        // Only unsuspend suspended sellers
        if (!$seller->isSuspended()) {
            return redirect()->back()->with('error', 'This seller is not suspended.');
        }
        
        // Update seller record
        $seller->update([
            'is_suspended' => false,
            'suspended_at' => null,
            'suspension_reason' => null,
            'suspended_by' => null
        ]);
        
        return redirect()->route('admin.sellers.show', $seller)
            ->with('success', 'Seller account has been reactivated successfully.');
    }
}
