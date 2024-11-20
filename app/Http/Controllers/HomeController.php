<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class HomeController extends Controller
{
    public function showHomePage()
    {
        $services = Service::all();
        return view('home', compact('services'));
    }
}
