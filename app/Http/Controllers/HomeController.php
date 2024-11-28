<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class HomeController extends Controller
{
    public function showHomePage()
    {
        $services = Service::where('is_approved', 1)->get();
        return view('home', compact('services'));
    }
}
