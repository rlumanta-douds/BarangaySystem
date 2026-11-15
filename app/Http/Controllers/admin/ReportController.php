<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resident;
use App\Models\Certificate;
use App\Models\Announcement;

class ReportController extends Controller
{
    /**
     * Display system summary reports with live database statistics.
     */
    public function index()
    {
        // Resident / Demographics Stats
        $totalResidents = Resident::count();

        // Certificates & Clearances Stats
        $totalCertificates = Certificate::count();
        $approvedCertificates = Certificate::where('status', 'Approved')->orWhere('status', 'Released')->count();
        $pendingCertificates = Certificate::where('status', 'Pending')->count();

        // Announcements Stats
        $totalAnnouncements = Announcement::count();

        // Blotters Stats (Safely handled if model exists)
        $totalBlotters = class_exists(\App\Models\Blotter::class) ? \App\Models\Blotter::count() : 0;
        $resolvedBlotters = class_exists(\App\Models\Blotter::class) ? \App\Models\Blotter::where('status', 'Resolved')->count() : 0;
        $ongoingBlotters = class_exists(\App\Models\Blotter::class) ? \App\Models\Blotter::where('status', 'Ongoing')->count() : 0;

        return view('admin.reports.index', compact(
            'totalResidents',
            'totalCertificates',
            'approvedCertificates',
            'pendingCertificates',
            'totalAnnouncements',
            'totalBlotters',
            'resolvedBlotters',
            'ongoingBlotters'
        ));
    }
}