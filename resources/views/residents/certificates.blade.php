@extends('layouts.app')

@section('content')
    <h1 class="resident-title" style="font-size: 1.75rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">Request a Certificate</h1>
    <p class="resident-muted" style="color: #64748b; margin-bottom: 25px; font-size: 0.9rem;">Complete the form for your barangay certificate request.</p>

    @if(session('success'))
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
            <i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i> {{ session('success') }}
        </div>
    @endif

    <form id="certificateForm" class="resident-form" method="POST" action="{{ route('resident.certificates.submit') }}" style="background: white; padding: 25px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); max-width: 600px;">
        @csrf

        <div style="margin-bottom: 18px;">
            <label for="certificate_type" style="display: block; font-weight: 600; font-size: 0.88rem; color: #334155; margin-bottom: 6px;">Certificate Type</label>
            <select id="certificate_type" name="certificate_type" required style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; background-color: #f8fafc; color: #1e293b; outline: none; transition: border-color 0.2s;">
                <option value="">Select certificate</option>
                <option value="Barangay Clearance">Barangay Clearance</option>
                <option value="Certificate of Residency">Certificate of Residency</option>
                <option value="Certificate of Indigency">Certificate of Indigency</option>
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="purpose" style="display: block; font-weight: 600; font-size: 0.88rem; color: #334155; margin-bottom: 6px;">Purpose</label>
            <textarea id="purpose" name="purpose" required placeholder="Enter the purpose of your request" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; background-color: #f8fafc; color: #1e293b; height: 110px; outline: none; resize: vertical;"></textarea>
        </div>

        <!-- Changed type to 'button' to trigger SweetAlert popup first -->
        <button class="resident-button" type="button" onclick="confirmSubmit()" style="background-color: #16a34a; color: white; border: none; padding: 10px 20px; font-size: 0.9rem; font-weight: 600; border-radius: 8px; cursor: pointer; transition: background-color 0.2s;">
            Submit Request
        </button>
    </form>

    <!-- Include SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmSubmit() {
            const certType = document.getElementById('certificate_type').value;
            const purpose = document.getElementById('purpose').value.trim();

            // Check if required fields are filled out before showing popup
            if (!certType || !purpose) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Form',
                    text: 'Please select a certificate type and enter a purpose.',
                    confirmButtonColor: '#16a34a'
                });
                return;
            }

            // Show confirmation pop up
            Swal.fire({
                title: 'Submit Request?',
                text: "Are you sure you want to submit this certificate request?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, Submit It',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('certificateForm').submit();
                }
            });
        }
    </script>
@endsection