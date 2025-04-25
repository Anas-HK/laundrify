<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\UserProfileUpdate;
use App\Models\User;

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
        Log::info('Profile update request received.');
        Log::info('Request Data:', $request->except('password', 'password_confirmation'));
        Log::info('Has profile_image file: ' . ($request->hasFile('profile_image') ? 'Yes' : 'No'));
        if ($request->hasFile('profile_image')) {
            Log::info('File details: ' . print_r($request->file('profile_image'), true));
        }
        
        try {
        $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login')->with('error', 'You must be logged in to update your profile.');
            }
            
            Log::info('Updating profile for user ID: ' . $user->id);
    
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
            
            $userToSave = User::find(Auth::id()); 
            if ($userToSave) {
                $userToSave->name = $request->name;
                $userToSave->email = $request->email;
                if ($request->filled('password')) {
                    $userToSave->password = Hash::make($request->password);
                }
                $userToSave->save();
                Log::info('User base details updated for ID: ' . $userToSave->id);
            } else {
                Log::error('Could not find user with ID: ' . Auth::id() . ' to save details.');
                throw new \Exception('Could not find user to save details.');
            }
    
        if ($request->hasFile('profile_image')) {
                try {
                    $file = $request->file('profile_image');
                    Log::info('Processing profile image upload: ' . $file->getClientOriginalName());
                    
                    if (!$file->isValid()) {
                        throw new \Exception('Uploaded file is not valid');
                    }
                    
                    $fileSize = $file->getSize();
                    $fileType = $file->getMimeType();
                    Log::info("File details: Size={$fileSize}bytes, Type={$fileType}");
                    
                    $directory = storage_path('app/public/profile_images');
                    if (!File::exists($directory)) {
                        Log::info('Creating directory: ' . $directory);
                        File::makeDirectory($directory, 0755, true);
                    }

            $profileUpdate = UserProfileUpdate::firstOrNew(['user_id' => $user->id]);
    
                    if ($profileUpdate->profile_image && Storage::disk('public')->exists($profileUpdate->profile_image)) {
                        Log::info('Deleting old profile image: ' . $profileUpdate->profile_image);
                Storage::disk('public')->delete($profileUpdate->profile_image); 
            }
    
                    $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                    
                    $path = Storage::disk('public')->putFileAs('profile_images', $file, $filename);
                    
                    if (!$path) {
                         throw new \Exception('Failed to store the uploaded file using putFileAs');
                    }
                    
                    Log::info('File stored using putFileAs to: ' . $path);
                    
                    $profileUpdate->user_id = $user->id;
            $profileUpdate->profile_image = $path;
            $profileUpdate->save();
                    
                    Log::info('Profile record updated with image: ' . $path);
                } catch (\Exception $uploadEx) {
                    Log::error('File upload specific error: ' . $uploadEx->getMessage());
                    Log::error('File upload stack trace: ' . $uploadEx->getTraceAsString());
                    return back()->withInput()->withErrors(['profile_image' => 'The profile image failed to upload: ' . $uploadEx->getMessage()]);
                }
            }
    
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . $e->getMessage());
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('General profile update error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->withInput()->withErrors(['error' => 'Failed to update profile: ' . $e->getMessage()]);
        }
    }
}
