<?php

namespace App\Http\Controllers\residents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\Auth;

class certificatesController extends Controller
{
    public function index()
    {
        return view('residents.certificates');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'certificate_type' => 'required|string|max:100',
            'purpose' => 'required|string|max:1000',
        ]);

        // Saves the request directly to your database
        CertificateRequest::create([
            'user_id' => Auth::id(),
            'certificate_type' => $validated['certificate_type'],
            'purpose' => $validated['purpose'],
            'status' => 'Pending',
        ]);

        return back()->with(
            'success',
            'Your certificate request has been successfully submitted and saved!'
        );
    }
}