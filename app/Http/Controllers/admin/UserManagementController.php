<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AccountSuspendedNotification;
use App\Notifications\AccountUnsuspendedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
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
     * Display a listing of the users.
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
        
        $query = User::query();
        
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
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.users.index', [
            'users' => $users,
            'filter' => $filter,
            'search' => $request->get('search', '')
        ]);
    }
    
    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        // Check admin access
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }
        // Load orders and other relevant info
        $user->load(['orders' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }]);
        
        // Get suspension history if applicable
        $suspensionInfo = null;
        if ($user->isSuspended()) {
            $suspensionInfo = [
                'suspended_at' => $user->suspended_at,
                'suspension_reason' => $user->suspension_reason,
                'suspended_by' => $user->suspendedBy ? $user->suspendedBy->name : 'Unknown Admin'
            ];
        }
        
        return view('admin.users.show', [
            'user' => $user,
            'suspensionInfo' => $suspensionInfo
        ]);
    }
    
    /**
     * Suspend a user account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function suspend(Request $request, User $user)
    {
        // Check admin access
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }
        $request->validate([
            'reason' => 'required|string|min:5|max:500',
        ]);
        
        // Don't suspend already suspended users
        if ($user->isSuspended()) {
            return redirect()->back()->with('error', 'This user is already suspended.');
        }
        
        // Don't allow admins to suspend themselves
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot suspend your own account.');
        }
        
        // Update user record
        $user->update([
            'is_suspended' => true,
            'suspended_at' => now(),
            'suspension_reason' => $request->reason,
            'suspended_by' => Auth::id()
        ]);
        
        // Notify user about suspension
        try {
            $user->notify(new AccountSuspendedNotification($request->reason));
        } catch (\Exception $e) {
            // Log error but continue
            \Log::error('Failed to send suspension notification: ' . $e->getMessage());
        }
        
        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User account has been suspended successfully.');
    }
    
    /**
     * Unsuspend a user account.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsuspend(User $user)
    {
        // Check admin access
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }
        // Only unsuspend suspended users
        if (!$user->isSuspended()) {
            return redirect()->back()->with('error', 'This user is not suspended.');
        }
        
        // Update user record
        $user->update([
            'is_suspended' => false,
            'suspended_at' => null,
            'suspension_reason' => null,
            'suspended_by' => null
        ]);
        
        // Notify user about unsuspension
        try {
            $user->notify(new AccountUnsuspendedNotification());
        } catch (\Exception $e) {
            // Log error but continue
            \Log::error('Failed to send unsuspension notification: ' . $e->getMessage());
        }
        
        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User account has been reactivated successfully.');
    }
}
