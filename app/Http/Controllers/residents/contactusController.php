<?php

namespace App\Http\Controllers\residents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blotter; // Ensure you import the Blotter model

class contactusController extends Controller
{
    public function index()
    {
        return view('residents.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $resident = auth()->user();
        $residentName = $resident->name ?? $resident->email ?? 'Resident';

        // Automatically save the resident's complaint/message as a Blotter record for the admin
        Blotter::create([
            'complainant' => $residentName,
            'respondent'  => 'Barangay Office / General Inquiry',
            'incident'    => $validated['subject'],
            'details'     => $validated['message'],
            'status'      => 'Pending',
        ]);

        return redirect()->route('resident.contact')->with('success', 'Your message has been successfully sent and saved as an official blotter/complaint record!');
    }
}