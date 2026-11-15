@extends('layouts.app')

@section('content')
<style>
    .profile-wrapper {
        max-width: 1100px;
        margin: 0 auto;
        padding: 24px;
    }
    .profile-header {
        margin-bottom: 24px;
    }
    .profile-header h2 {
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 4px 0;
    }
    .profile-header p {
        color: #6b7280;
        margin: 0;
        font-size: 14px;
    }
    .profile-grid {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 24px;
        align-items: stretch;
    }
    @media (max-width: 900px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }
    .card {
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    /* Left Profile Identity Card */
    .profile-banner {
        height: 120px;
        background: linear-gradient(135deg, #064e3b 0%, #059669 100%);
        flex-shrink: 0;
    }
    .avatar-section {
        text-align: center;
        padding: 0 24px 28px;
        margin-top: -60px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .avatar-container {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 16px;
    }
    .avatar-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        background: #ecfdf5;
    }
    .avatar-upload-btn {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #059669;
        color: #ffffff;
        border: 2px solid #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    .avatar-upload-btn:hover {
        background: #047857;
    }
    .resident-name {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 4px;
    }
    .resident-email {
        font-size: 13px;
        color: #6b7280;
        margin: 0 0 14px;
    }
    .role-badge {
        display: inline-block;
        padding: 5px 16px;
        background: #d1fae5;
        color: #065f46;
        font-size: 12px;
        font-weight: 600;
        border-radius: 999px;
    }
    .status-footer {
        margin-top: auto;
        padding-top: 18px;
        border-top: 1px solid #f3f4f6;
    }
    .verified-note {
        font-size: 13px;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-weight: 600;
    }
    .btn-save-photo {
        margin-top: 16px;
        width: 100%;
        background: #059669;
        color: #ffffff;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-save-photo:hover {
        background: #047857;
    }
    /* Right Permanent Record Card */
    .form-card-header {
        padding: 20px 28px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .form-card-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #111827;
    }
    .lock-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #6b7280;
        background: #f3f4f6;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 500;
    }
    .form-card-body {
        padding: 28px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 18px;
    }
    @media (max-width: 640px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
    .form-group {
        margin-bottom: 18px;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }
    .form-control[readonly] {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        background-color: #f9fafb;
        color: #374151;
        cursor: not-allowed;
        box-sizing: border-box;
    }
    .permanent-notice {
        margin-top: 20px;
        padding: 12px 16px;
        background: #f8fafc;
        border-left: 3px solid #059669;
        border-radius: 6px;
        font-size: 13px;
        color: #4b5563;
    }
    .alert-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }
</style>

<div class="profile-wrapper">
    <div class="profile-header">
        <h2>My Profile</h2>
        <p>View your registered barangay information and update your profile photo.</p>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-grid">
        <!-- Left Column: Avatar & Photo Upload Form -->
        <div class="card">
            <div class="profile-banner"></div>
            <div class="avatar-section">
                <form action="{{ route('resident.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="avatar-container">
                        <img
                            id="avatarPreview"
                            class="avatar-img"
                            src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=059669&color=fff&size=200' }}"
                            alt="Profile Photo"
                        >
                        <label for="profile_photo" class="avatar-upload-btn" title="Choose Profile Photo">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display: none;" onchange="previewImage(event)">
                    </div>

                    <h4 class="resident-name">{{ Auth::user()->name }}</h4>
                    <p class="resident-email">{{ Auth::user()->email }}</p>
                    <span class="role-badge">Resident</span>

                    <button type="submit" id="savePhotoBtn" class="btn-save-photo" style="display: none;">
                        Save Profile Photo
                    </button>
                </form>

                <div class="status-footer">
                    <div class="verified-note">
                        <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Linked to Barangay Records
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Permanent Read-Only Personal Information -->
        <div class="card">
            <div class="form-card-header">
                <h3>Personal Information</h3>
                <span class="lock-badge">
                    <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    Permanent Record
                </span>
            </div>
            <div class="form-card-body">
                <div>
                    <div class="form-row">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Full Name</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label>Email Address</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->email }}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Residential Address</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->resident->address ?? 'Narciso Street, Washington, Surigao City' }}" readonly>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Account Type</label>
                        <input type="text" class="form-control" value="Resident" readonly>
                    </div>
                </div>

                <div class="permanent-notice">
                    Official barangay resident profile is permanent and securely linked to database records. To request changes to your name, email, or address, please contact the Barangay Administrator.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('avatarPreview').src = reader.result;
            document.getElementById('savePhotoBtn').style.display = 'block';
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection