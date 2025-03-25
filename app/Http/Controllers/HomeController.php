<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Seller;
use Illuminate\Support\Facades\Log;
use App\Models\Feedback;


class HomeController extends Controller
{
    public function showHomePage()
    {
        $feedbacks = Feedback::latest()->get(); // Fetch all feedback
        $services = Service::where('is_approved', 1)->get();
        $sellers = Seller::where('is_deleted', false)->where('accountIsApproved', 1)->get();
        // $notifications = auth()->user()->notifications()->latest()->take(5)->get();

        return view('home', compact('services', 'sellers', 'feedbacks'));
    }

    
    public function index()
    {   
        // PHP error log method
        Log::info('Session data:', session()->all());
        $sellers = Seller::where('is_deleted', false)->where('accountIsApproved', 1)->get(); 
        return view('home', compact('sellers'));
    }
}
