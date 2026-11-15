@extends('layouts.app')

@section('content')
<style>
    .container-fluid { padding: 25px 30px; }
    
    .page-header { margin-bottom: 25px; }
    .page-title h1 { font-size: 1.8rem; font-weight: 700; color: #1e293b; margin: 0; }
    .page-title p { color: #64748b; font-size: 0.95rem; margin-top: 4px; margin-bottom: 0; }

    /* Profile Card Layout */
    .profile-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); max-width: 800px; overflow: hidden; }
    
    .profile-card-header { background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 20px 25px; display: flex; align-items: center; gap: 15px; }
    .avatar-icon { width: 55px; height: 55px; background-color: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700; flex-shrink: 0; }
    
    .user-header-info h2 { font-size: 1.25rem; font-weight: 700; color: #1e293b; margin: 0; }
    .user-header-info span { font-size: 0.85rem; color: #64748b; font-weight: 500; }

    .profile-card-body { padding: 25px; }
    
    /* Info Grid */
    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px; }
    .info-item { display: flex; flex-direction: column; gap: 4px; background: #f8fafc; padding: 12px 16px; border-radius: 8px; border: 1px solid #f1f5f9; }
    .info-label { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; }
    .info-value { font-size: 0.95rem; font-weight: 600; color: #1e293b; }

    .badge-resident { display: inline-block; background-color: #dcfce7; color: #15803d; font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 12px; width: fit-content; }

    .profile-card-footer { border-top: 1px dashed #e2e8f0; padding-top: 15px; font-size: 0.85rem; color: #94a3b8; display: flex; align-items: center; gap: 8px; }
</style>

<div class="container-fluid">
    <div class="page-header">
        <div class="page-title">
            <h1>My Profile</h1>
            <p>View your official registered barangay resident information.</p>
        </div>
    </div>

    <div class="profile-card">
        <div class="profile-card-header">
            <div class="avatar-icon">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="user-header-info">
                <h2>{{ auth()->user()->name ?? 'Niko Robin' }}</h2>
                <span>Registered Resident • Surigao City</span>
            </div>
        </div>

        <div class="profile-card-body">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">{{ auth()->user()->name ?? 'Niko Robin' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Email Address</span>
                    <span class="info-value">{{ auth()->user()->email ?? 'resident@gmail.com' }}</span>
                </div>

                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Address</span>
                    <span class="info-value">{{ auth()->user()->address ?? 'Narciso Street, Washington, Surigao City' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Account Type</span>
                    <span class="info-value">
                        <span class="badge-resident">Resident</span>
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">Account Status</span>
                    <span class="info-value" style="color: #16a34a;"><i class="fa-solid fa-circle-check"></i> Active & Verified</span>
                </div>
            </div>

            <div class="profile-card-footer">
                <i class="fa-solid fa-circle-info"></i>
                <span>Official barangay records are managed and verified by the Barangay Secretariat.</span>
            </div>
        </div>
    </div>
</div>
@endsection