<?php

namespace App\Http\Controllers\residents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\Auth;

class requestsController extends Controller
{
    public function index()
    {
        // Fetch only the requests made by the currently logged-in resident
        $requests = CertificateRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('residents.history', compact('requests'));
    }
}