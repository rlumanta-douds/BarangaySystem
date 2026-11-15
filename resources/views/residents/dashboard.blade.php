@extends('layouts.app')

@section('content')
<style>
    .welcome-banner { margin-bottom: 20px; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); padding: 20px 24px; border-radius: 12px; border: 1px solid #bbf7d0; }
    .welcome-banner h1 { font-size: 1.6rem; font-weight: 700; color: #14532d; }
    .welcome-banner p { color: #166534; margin-top: 4px; font-size: 0.9rem; }

    /* Compact 4-Column Inline Grid */
    .portal-grid { 
        display: grid; 
        grid-template-columns: repeat(4, 1fr); 
        gap: 15px; 
        margin-bottom: 25px; 
    }

    @media (max-width: 1100px) {
        .portal-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .portal-grid { grid-template-columns: 1fr; }
    }

    /* Small Compact Inline Cards */
    .portal-card { 
        background: white; 
        padding: 14px 16px; 
        border-radius: 10px; 
        box-shadow: 0 1px 3px rgba(0,0,0,0.04); 
        border: 1px solid #e2e8f0; 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        transition: all 0.2s ease; 
        text-decoration: none; 
        color: inherit; 
    }

    .portal-card:hover { 
        transform: translateY(-2px); 
        border-color: #86efac; 
        box-shadow: 0 4px 10px rgba(22, 163, 74, 0.08); 
        background-color: #f0fdf4;
    }
    
    .card-icon { 
        width: 42px; 
        height: 42px; 
        border-radius: 8px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 1.1rem; 
        background-color: #f0fdf4; 
        color: #16a34a; 
        flex-shrink: 0; 
    }

    .portal-card:hover .card-icon {
        background-color: #16a34a;
        color: white;
    }
    
    .card-info { flex-grow: 1; min-width: 0; }
    .card-info h3 { font-size: 0.92rem; font-weight: 700; color: #1e293b; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .card-info p { font-size: 0.78rem; color: #64748b; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .card-arrow { color: #cbd5e1; font-size: 0.8rem; transition: color 0.2s, transform 0.2s; }
    .portal-card:hover .card-arrow { color: #16a34a; transform: translateX(3px); }

    /* Summary Layout */
    .dashboard-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
    @media (max-width: 900px) { .dashboard-layout { grid-template-columns: 1fr; } }

    .card-box { background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .card-box-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9; }
    .card-box-header h3 { font-size: 0.95rem; font-weight: 700; color: #1e293b; }
</style>

<div class="welcome-banner">
    <h1>Welcome, {{ Auth::user()->name ?? 'Resident' }}!</h1>
    <p>Access barangay services, request official documents, and manage your resident profile all in one place.</p>
</div>

<!-- Compact Horizontal 4-Card Grid -->
<div class="portal-grid">
    <!-- My Profile -->
    <a href="{{ route('resident.profile') }}" class="portal-card">
        <div class="card-icon"><i class="fa-solid fa-id-card"></i></div>
        <div class="card-info">
            <h3>My Profile</h3>
            <p>Personal Info</p>
        </div>
        <i class="fa-solid fa-chevron-right card-arrow"></i>
    </a>

    <!-- Certificates -->
    <a href="{{ route('resident.certificates') }}" class="portal-card">
        <div class="card-icon"><i class="fa-solid fa-file-invoice"></i></div>
        <div class="card-info">
            <h3>Certificates</h3>
            <p>Document Requests</p>
        </div>
        <i class="fa-solid fa-chevron-right card-arrow"></i>
    </a>

    <!-- Announcements -->
    <a href="{{ route('resident.announcements') }}" class="portal-card">
        <div class="card-icon"><i class="fa-solid fa-bullhorn"></i></div>
        <div class="card-info">
            <h3>Announcements</h3>
            <p>Barangay News</p>
        </div>
        <i class="fa-solid fa-chevron-right card-arrow"></i>
    </a>

    <!-- Request History -->
    <a href="{{ route('resident.history') }}" class="portal-card">
        <div class="card-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
        <div class="card-info">
            <h3>Request History</h3>
            <p>Status Tracking</p>
        </div>
        <i class="fa-solid fa-chevron-right card-arrow"></i>
    </a>
</div>

<!-- Bottom Info Section -->
<div class="dashboard-layout">
    <div class="card-box">
        <div class="card-box-header">
            <h3><i class="fa-solid fa-circle-info" style="color:#16a34a; margin-right:6px;"></i> Quick Assistance & Support</h3>
        </div>
        <div style="font-size: 0.88rem; color: #475569; line-height: 1.6;">
            <p style="margin-bottom: 12px;">Need urgent help or have inquiries regarding barangay services? You can get in touch with our office support staff directly.</p>
            <a href="{{ route('resident.contact') }}" style="display: inline-block; background-color: #16a34a; color: white; padding: 8px 16px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 0.85rem;">Contact Support</a>
        </div>
    </div>

    <div class="card-box">
        <div class="card-box-header">
            <h3><i class="fa-solid fa-calendar-days" style="color:#16a34a; margin-right:6px;"></i> Barangay Office Hours</h3>
        </div>
        <div style="font-size: 0.85rem; color: #475569; line-height: 1.8;">
            <p><strong>Monday – Friday:</strong> 8:00 AM – 5:00 PM</p>
            <p><strong>Saturday:</strong> 8:00 AM – 12:00 NN</p>
            <p><strong>Sunday / Holidays:</strong> Closed</p>
        </div>
    </div>
</div>
@endsection