<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingSellers = Seller::where('accountIsApproved', 0)->where('is_deleted', 0)->get();
        return view('admin.dashboard', compact('pendingSellers'));
    }

    public function approveSeller($id)
    {
        $seller = Seller::find($id);
        $seller->accountIsApproved = 1;
        $seller->save();

        return redirect()->route('admin.dashboard')->with('status', 'Seller approved successfully.');
    }

    public function rejectSeller($id)
    {
        $seller = Seller::find($id);
        $seller->is_deleted = 1;
        $seller->save();

        return redirect()->route('admin.dashboard')->with('status', 'Seller rejected and deleted.');
    }
}
