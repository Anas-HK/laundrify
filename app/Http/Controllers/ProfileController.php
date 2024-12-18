<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\UserProfileUpdate;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profileUpdate = UserProfileUpdate::where('user_id', $user->id)->first();
        return view('profile.edit', ['user' => $user, 'profileUpdate' => $profileUpdate]);
    }
    public function update(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user->name = $request->name;
        $user->email = $request->email;
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        if ($request->hasFile('profile_image')) {
            $profileUpdate = UserProfileUpdate::firstOrNew(['user_id' => $user->id]);
    
            if ($profileUpdate->profile_image) {
                Storage::disk('public')->delete($profileUpdate->profile_image); // Delete old image
            }
    
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $profileUpdate->profile_image = $path;
            $profileUpdate->save();
        }
    
        $user->save();
    
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }
}
