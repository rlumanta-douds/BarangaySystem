<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\Schema;

class CertificateController extends Controller
{
    /**
     * Display all certificate requests for the admin.
     */
    public function index()
    {
        $certificates = CertificateRequest::latest()->get();
        return view('admin.certificates.index', compact('certificates'));
    }

    /**
     * Store a new certificate request from the admin side.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_name'    => 'nullable|string|max:255',
            'certificate_type' => 'required|string|max:255',
            'purpose'          => 'required|string|max:255',
            'status'           => 'required|string|max:50',
        ]);

        $data = [
            'purpose' => $validated['purpose'],
            'status'  => $validated['status'],
        ];

        if (Schema::hasColumn('certificate_requests', 'certificate_id')) {
            $data['certificate_id'] = '#CERT-' . rand(1000, 9999);
        }

        if (Schema::hasColumn('certificate_requests', 'resident_name')) {
            $data['resident_name'] = $validated['resident_name'] ?? 'Unknown Resident';
        }

        if (Schema::hasColumn('certificate_requests', 'certificate_type')) {
            $data['certificate_type'] = $validated['certificate_type'];
        } elseif (Schema::hasColumn('certificate_requests', 'type')) {
            $data['type'] = $validated['certificate_type'];
        }

        CertificateRequest::create($data);

        return redirect()->route('certificates.page')->with('success', 'Certificate request added successfully!');
    }

    /**
     * Update an existing certificate request.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'resident_name'    => 'nullable|string|max:255',
            'certificate_type' => 'required|string|max:255',
            'purpose'          => 'required|string|max:255',
            'status'           => 'required|string|max:50',
        ]);

        $certificate = CertificateRequest::findOrFail($id);

        $updateData = [
            'purpose' => $validated['purpose'],
            'status'  => $validated['status'],
        ];

        if (Schema::hasColumn('certificate_requests', 'resident_name')) {
            $updateData['resident_name'] = $validated['resident_name'];
        }

        if (Schema::hasColumn('certificate_requests', 'certificate_type')) {
            $updateData['certificate_type'] = $validated['certificate_type'];
        } elseif (Schema::hasColumn('certificate_requests', 'type')) {
            $updateData['type'] = $validated['certificate_type'];
        }

        $certificate->update($updateData);

        return redirect()->route('certificates.page')->with('success', 'Certificate request updated successfully!');
    }

    /**
     * Delete a certificate request.
     */
    public function destroy($id)
    {
        $certificate = CertificateRequest::findOrFail($id);
        $certificate->delete();

        return redirect()->route('certificates.page')->with('success', 'Certificate request deleted successfully!');
    }
}