@extends('layouts.app')

@section('content')
<style>
    /* ========================================================
       1. OVERVIEW CARDS (ALL 4 IN 1 HORIZONTAL LINE)
       ======================================================== */
    .dashboard-cards-container {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        gap: 16px !important;
        width: 100% !important;
        margin-bottom: 30px !important;
    }

    .dashboard-card {
        flex: 1 1 0% !important;
        min-width: 0 !important;
        background: #ffffff !important;
        border-radius: 12px !important;
        padding: 20px 16px !important;
        display: flex !important;
        align-items: center !important;
        gap: 14px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }

    .dashboard-card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06) !important;
    }

    .card-icon-box {
        width: 48px !important;
        height: 48px !important;
        border-radius: 10px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 1.25rem !important;
        flex-shrink: 0 !important;
    }

    /* Icon Colors */
    .bg-light-green  { background-color: #d1fae5 !important; color: #059669 !important; }
    .bg-light-blue   { background-color: #dbeafe !important; color: #2563eb !important; }
    .bg-light-yellow { background-color: #fef3c7 !important; color: #d97706 !important; }
    .bg-light-red    { background-color: #fee2e2 !important; color: #dc2626 !important; }

    .card-title-text {
        font-size: 0.82rem !important;
        font-weight: 500 !important;
        color: #64748b !important;
        margin-bottom: 2px !important;
        white-space: nowrap !important;
    }

    .card-value-text {
        font-size: 1.6rem !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        line-height: 1 !important;
    }

    /* ========================================================
       2. QUICK NAVIGATION BUTTONS (ALL 5 IN 1 HORIZONTAL LINE)
       ======================================================== */
    .quick-nav-title {
        font-size: 1.1rem !important;
        font-weight: 600 !important;
        color: #1e293b !important;
        margin-bottom: 16px !important;
    }

    .quick-nav-container {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        gap: 12px !important;
        width: 100% !important;
        margin-bottom: 35px !important;
    }

    .quick-nav-card {
        flex: 1 1 0% !important;
        min-width: 0 !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        padding: 16px 14px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        text-decoration: none !important;
        color: #1e293b !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
        transition: all 0.2s ease !important;
    }

    .quick-nav-card:hover {
        border-color: #10b981 !important;
        color: #047857 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.1) !important;
    }

    .quick-nav-card i {
        color: #10b981 !important;
        font-size: 0.9rem !important;
        transition: transform 0.2s !important;
    }

    .quick-nav-card:hover i {
        transform: translateX(3px) !important;
    }

    /* ========================================================
       3. LOWER SUMMARY SECTION (TABLES & ACTIVITY)
       ======================================================== */
    .bottom-summary-grid {
        display: grid !important;
        grid-template-columns: 2fr 1fr !important;
        gap: 20px !important;
    }

    .summary-card-box {
        background: #ffffff !important;
        border-radius: 12px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 20px !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;
    }

    .summary-card-header {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-bottom: 15px !important;
        padding-bottom: 10px !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .summary-card-header h3 {
        font-size: 1rem !important;
        font-weight: 600 !important;
        color: #1e293b !important;
    }

    .summary-table {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 0.875rem !important;
    }

    .summary-table th {
        text-align: left !important;
        padding: 10px 12px !important;
        color: #64748b !important;
        font-weight: 600 !important;
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }

    .summary-table td {
        padding: 12px !important;
        border-bottom: 1px solid #f1f5f9 !important;
        color: #334155 !important;
    }

    .status-badge {
        padding: 4px 10px !important;
        border-radius: 6px !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        display: inline-block !important;
    }
    .status-pending { background-color: #fef3c7 !important; color: #d97706 !important; }
    .status-approved { background-color: #d1fae5 !important; color: #059669 !important; }

    /* Responsive adjustments for lower resolution screens */
    @media (max-width: 1024px) {
        .dashboard-cards-container, .quick-nav-container {
            flex-wrap: wrap !important;
        }
        .dashboard-card, .quick-nav-card {
            flex: 1 1 45% !important;
        }
        .bottom-summary-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Dashboard Welcome Header -->
<div style="margin-bottom: 25px;">
    <h2 style="font-size: 1.6rem; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Dashboard Overview</h2>
    <p style="color: #64748b; font-size: 0.9rem;">Welcome back, Head Administrator! Here is the latest summary of barangay operations and records.</p>
</div>

<!-- TOP 4 OVERVIEW CARDS -->
<div class="dashboard-cards-container">
    
    <!-- Card 1: Total Residents -->
    <div class="dashboard-card">
        <div class="card-icon-box bg-light-green">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <div class="card-title-text">Total Residents</div>
            <div class="card-value-text">{{ $totalResidents ?? '10' }}</div>
        </div>
    </div>

    <!-- Card 2: Certificate Requests -->
    <div class="dashboard-card">
        <div class="card-icon-box bg-light-blue">
            <i class="fa-solid fa-file-lines"></i>
        </div>
        <div>
            <div class="card-title-text">Certificate Requests</div>
            <div class="card-value-text">{{ $certRequests ?? '3' }}</div>
        </div>
    </div>

    <!-- Card 3: Announcements -->
    <div class="dashboard-card">
        <div class="card-icon-box bg-light-yellow">
            <i class="fa-solid fa-bullhorn"></i>
        </div>
        <div>
            <div class="card-title-text">Announcements</div>
            <div class="card-value-text">{{ $announcementsCount ?? '4' }}</div>
        </div>
    </div>

    <!-- Card 4: Blotter Records -->
    <div class="dashboard-card">
        <div class="card-icon-box bg-light-red">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <div>
            <div class="card-title-text">Blotter Records</div>
            <div class="card-value-text">{{ $blotterCount ?? '3' }}</div>
        </div>
    </div>

</div>

<!-- QUICK NAVIGATION BUTTONS -->
<div class="quick-nav-title">Quick Navigation</div>

<div class="quick-nav-container">
    <a href="{{ route('residents.page') }}" class="quick-nav-card">
        <span>Manage Residents</span>
        <i class="fa-solid fa-arrow-right"></i>
    </a>
    <a href="{{ route('certificates.page') }}" class="quick-nav-card">
        <span>Issue Certificates</span>
        <i class="fa-solid fa-arrow-right"></i>
    </a>
    <a href="{{ route('announcements.page') }}" class="quick-nav-card">
        <span>Post Announcement</span>
        <i class="fa-solid fa-arrow-right"></i>
    </a>
    <a href="{{ route('blotter.page') }}" class="quick-nav-card">
        <span>View Blotter Complaints</span>
        <i class="fa-solid fa-arrow-right"></i>
    </a>
    <a href="{{ route('reports.page') }}" class="quick-nav-card">
        <span>Generate Reports</span>
        <i class="fa-solid fa-arrow-right"></i>
    </a>
</div>

<!-- LOWER SUMMARY SECTION -->
<div class="bottom-summary-grid">
    
    <!-- Recent Activity / Requests Table -->
    <div class="summary-card-box">
        <div class="summary-card-header">
            <h3>Recent Certificate Requests</h3>
            <a href="{{ route('certificates.page') }}" style="color: #059669; font-size: 0.85rem; font-weight: 600; text-decoration: none;">View All</a>
        </div>
        <table class="summary-table">
            <thead>
                <tr>
                    <th>Resident Name</th>
                    <th>Certificate Type</th>
                    <th>Date Requested</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentRequests ?? [] as $request)
                    <tr>
                        <td>{{ $request->resident_name }}</td>
                        <td>{{ $request->certificate_type }}</td>
                        <td>{{ $request->created_at->format('M d, Y') }}</td>
                        <td><span class="status-badge {{ $request->status == 'Approved' ? 'status-approved' : 'status-pending' }}">{{ $request->status }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td>Juan Dela Cruz</td>
                        <td>Barangay Clearance</td>
                        <td>Oct 20, 2026</td>
                        <td><span class="status-badge status-pending">Pending</span></td>
                    </tr>
                    <tr>
                        <td>Maria Santos</td>
                        <td>Certificate of Indigency</td>
                        <td>Oct 19, 2026</td>
                        <td><span class="status-badge status-approved">Approved</span></td>
                    </tr>
                    <tr>
                        <td>Antonio Luna</td>
                        <td>Barangay Residency</td>
                        <td>Oct 18, 2026</td>
                        <td><span class="status-badge status-approved">Approved</span></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Recent Announcements Feed -->
    <div class="summary-card-box">
        <div class="summary-card-header">
            <h3>Latest Announcements</h3>
            <a href="{{ route('announcements.page') }}" style="color: #059669; font-size: 0.85rem; font-weight: 600; text-decoration: none;">View All</a>
        </div>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @forelse($recentAnnouncements ?? [] as $announcement)
                <div style="padding: 12px; background: #f8fafc; border-radius: 8px; border: 1px solid #f1f5f9;">
                    <div style="font-weight: 600; font-size: 0.875rem; color: #1e293b;">{{ $announcement->title }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">{{ $announcement->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <div style="padding: 12px; background: #f8fafc; border-radius: 8px; border: 1px solid #f1f5f9;">
                    <div style="font-weight: 600; font-size: 0.875rem; color: #1e293b;">Community Cleanup Drive</div>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">Posted 2 hours ago</div>
                </div>
                <div style="padding: 12px; background: #f8fafc; border-radius: 8px; border: 1px solid #f1f5f9;">
                    <div style="font-weight: 600; font-size: 0.875rem; color: #1e293b;">Free Health Checkup Schedule</div>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">Posted Yesterday</div>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection