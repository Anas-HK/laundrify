<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the user's favorited services.
     */
    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favoritedServices()->with('seller')->get();
        
        return view('favorites.index', compact('favorites'));
    }
    
    /**
     * Toggle the favorite status of a service.
     */
    public function toggle(Request $request, $serviceId)
    {
        $user = Auth::user();
        $service = Service::findOrFail($serviceId);
        
        // Check if the service is already favorited
        $favorite = Favorite::where('user_id', $user->id)
                           ->where('service_id', $service->id)
                           ->first();
        
        if ($favorite) {
            // If already favorited, remove from favorites
            $favorite->delete();
            $isFavorited = false;
            $message = 'Service removed from favorites';
        } else {
            // If not favorited, add to favorites
            Favorite::create([
                'user_id' => $user->id,
                'service_id' => $service->id
            ]);
            $isFavorited = true;
            $message = 'Service added to favorites';
        }
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'isFavorited' => $isFavorited,
                'message' => $message
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Check if a service is favorited by the current user.
     */
    public function isFavorited($serviceId)
    {
        if (!Auth::check()) {
            return response()->json(['isFavorited' => false]);
        }
        
        $user = Auth::user();
        $isFavorited = Favorite::where('user_id', $user->id)
                              ->where('service_id', $serviceId)
                              ->exists();
        
        return response()->json(['isFavorited' => $isFavorited]);
    }
    
    /**
     * Remove a service from favorites.
     */
    public function remove(Request $request, $serviceId)
    {
        $user = Auth::user();
        
        $favorite = Favorite::where('user_id', $user->id)
                           ->where('service_id', $serviceId)
                           ->first();
        
        if ($favorite) {
            $favorite->delete();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Service removed from favorites'
                ]);
            }
            
            return redirect()->route('favorites.index')->with('success', 'Service removed from favorites');
        }
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found in favorites'
            ], 404);
        }
        
        return redirect()->route('favorites.index')->with('error', 'Service not found in favorites');
    }
}
