<?php

namespace App\Http\Controllers\residents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class announcementsController extends Controller
{
    /**
     * Display live announcements created by the admin to residents.
     */
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('residents.announcements', compact('announcements'));
    }
}