<?php

namespace App\Http\Controllers\residents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    /**
     * Display the resident dashboard.
     */
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Pass data or return the resident dashboard view
        return view('residents.dashboard', compact('user'));
    }
}