<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Certificate;
use App\Models\Announcement;
use App\Models\Blotter; // Import the Blotter model

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard with live stats.
     */
    public function index()
    {
        // Live counts from database
        $residentCount = Resident::count();
        $certificateCount = Certificate::count();
        $totalCertificates = $certificateCount;
        
        $announcementCount = Announcement::count();
        $totalAnnouncements = $announcementCount;

        // Dynamic Blotter Count
        $blotterCount = Blotter::count();
        $totalBlotters = $blotterCount;

        $recentCertificates = Certificate::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'residentCount',
            'certificateCount',
            'totalCertificates',
            'announcementCount',
            'totalAnnouncements',
            'blotterCount',
            'totalBlotters',
            'recentCertificates'
        ));
    }
}