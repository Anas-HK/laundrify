<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Seller;

class HomeController extends Controller
{
    public function showHomePage()
    {
        $services = Service::where('is_approved', 1)->get();
        $sellers = Seller::where('is_deleted', false)->where('accountIsApproved', 1)->get();

        return view('home', compact('services', 'sellers'));
    }

    public function index()
    {
        $sellers = Seller::where('is_deleted', false)->where('accountIsApproved', 1)->get(); // Only approved sellers
        return view('home', compact('sellers'));
    }
}
