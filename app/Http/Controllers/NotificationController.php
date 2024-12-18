<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this line


class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->latest()->get();
        $unreadCount = $user->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(Request $request)
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead(); // Mark all unread as read

        return redirect()->back(); // Refresh the page or redirect to the same page
    }
    public function redirectToService($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $serviceUrl = $notification->data['service_url']; // Assuming the service URL is stored in the notification data

        return redirect($serviceUrl);
    }
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return redirect()->back();
    }

  
}
