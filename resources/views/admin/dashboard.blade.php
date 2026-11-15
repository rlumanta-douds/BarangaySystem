@extends('layouts.app')

@section('content')
<style>
    /* ========================================================
       1. TOP HEADER & COMPACT QUICK NAVIGATION BAR
       ======================================================== */
    .dashboard-top-bar {
        display: flex !important;
        justify-content: space-between !important;
        align-items: flex-end !important;
        flex-wrap: wrap !important;
        gap: 16px !important;
        margin-bottom: 24px !important;
    }

    .quick-nav-strip {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 10px !important;
        margin-bottom: 26px !important;
    }

    .quick-nav-card {
        flex: 1 1 170px !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-left: 4px solid #059669 !important;
        border-radius: 10px !important;
        padding: 13px 14px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        text-decoration: none !important;
        color: #1e293b !important;
        font-size: 0.84rem !important;
        font-weight: 600 !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
        transition: all 0.2s ease !important;
    }

    .quick-nav-card:hover {
        background-color: #ecfdf5 !important;
        border-color: #10b981 !important;
        color: #064e3b !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.12) !important;
    }

    .quick-nav-card i {
        color: #059669 !important;
        font-size: 0.88rem !important;
        transition: transform 0.2s !important;
    }

    .quick-nav-card:hover i {
        transform: translateX(3px) !important;
    }

    /* ========================================================
       2. ANALYTICS CHARTS & GRAPHS SECTION
       ======================================================== */
    .analytics-grid {
        display: grid !important;
        grid-template-columns: 1.75fr 1fr !important;
        gap: 20px !important;
        margin-bottom: 26px !important;
    }

    .chart-card-box {
        background: #ffffff !important;
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 20px !important;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04) !important;
    }

    .chart-header {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        margin-bottom: 16px !important;
    }

    .chart-header h3 {
        font-size: 1rem !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        margin: 0 !important;
    }

    .chart-subtitle {
        font-size: 0.78rem !important;
        color: #64748b !important;
        margin-top: 2px !important;
    }

    .green-tag {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
        font-size: 0.74rem !important;
        font-weight: 600 !important;
        padding: 4px 10px !important;
        border-radius: 999px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 5px !important;
    }

    /* ========================================================
       3. LOWER SUMMARY SECTION (TABLES & ANNOUNCEMENTS)
       ======================================================== */
    .bottom-summary-grid {
        display: grid !important;
        grid-template-columns: 1.75fr 1fr !important;
        gap: 20px !important;
    }

    .summary-card-box {
        background: #ffffff !important;
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 20px !important;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04) !important;
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
        font-weight: 700 !important;
        color: #0f172a !important;
        margin: 0 !important;
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

    /* Green-Only Status Badges */
    .status-badge {
        padding: 4px 10px !important;
        border-radius: 999px !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 5px !important;
    }
    .status-pending {
        background-color: #ecfdf5 !important;
        color: #047857 !important;
        border: 1px solid #a7f3d0 !important;
    }
    .status-approved {
        background-color: #d1fae5 !important;
        color: #064e3b !important;
    }

    /* Responsive adjustments */
    @media (max-width: 1100px) {
        .analytics-grid, .bottom-summary-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Dashboard Welcome Header -->
<div class="dashboard-top-bar">
    <div>
        <h2 style="font-size: 1.65rem; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Dashboard Overview</h2>
        <p style="color: #64748b; font-size: 0.9rem; margin: 0;">Welcome back, {{ auth()->user()->name ?? 'Head Administrator' }}! Here is the latest summary of barangay operations and records.</p>
    </div>
    <span class="green-tag"><i class="fa-solid fa-circle-check"></i> System Active &bull; 2026</span>
</div>

<!-- COMPACT QUICK NAVIGATION STRIP -->
<div class="quick-nav-strip">
    <a href="{{ route('residents.page') }}" class="quick-nav-card">
        <span><i class="fa-solid fa-users" style="margin-right: 7px;"></i>Manage Residents</span>
        <i class="fa-solid fa-arrow-right"></i>
    </a>
    <a href="{{ route('certificates.page') }}" class="quick-nav-card">
        <span><i class="fa-solid fa-file-lines" style="margin-right: 7px;"></i>Issue Certificates</span>
        <i class="fa-solid fa-arrow-right"></i>
    </a>
    <a href="{{ route('announcements.page') }}" class="quick-nav-card">
        <span><i class="fa-solid fa-bullhorn" style="margin-right: 7px;"></i>Post Announcement</span>
        <i class="fa-solid fa-arrow-right"></i>
    </a>
    <a href="{{ route('blotter.page') }}" class="quick-nav-card">
        <span><i class="fa-solid fa-shield-halved" style="margin-right: 7px;"></i>Blotter Complaints</span>
        <i class="fa-solid fa-arrow-right"></i>
    </a>
    <a href="{{ route('reports.page') }}" class="quick-nav-card">
        <span><i class="fa-solid fa-chart-column" style="margin-right: 7px;"></i>Generate Reports</span>
        <i class="fa-solid fa-arrow-right"></i>
    </a>
</div>

<!-- GRAPHS & CHARTS SECTION (MONOCHROME GREEN) -->
<div class="analytics-grid">
    <!-- Monthly Operations Bar Chart -->
    <div class="chart-card-box">
        <div class="chart-header">
            <div>
                <h3>Monthly Barangay Operations</h3>
                <div class="chart-subtitle">Certificates issued vs. new resident records</div>
            </div>
            <span class="green-tag"><i class="fa-solid fa-chart-simple"></i> 6-Month Trend</span>
        </div>
        <div style="height: 260px; position: relative;">
            <canvas id="barangayActivityChart"></canvas>
        </div>
    </div>

    <!-- Records Distribution Doughnut Chart -->
    <div class="chart-card-box">
        <div class="chart-header">
            <div>
                <h3>Records Distribution</h3>
                <div class="chart-subtitle">Breakdown across system modules</div>
            </div>
            <span class="green-tag"><i class="fa-solid fa-chart-pie"></i> Summary</span>
        </div>
        <div style="height: 260px; position: relative;">
            <canvas id="recordsDistributionChart"></canvas>
        </div>
    </div>
</div>

<!-- LOWER SUMMARY SECTION -->
<div class="bottom-summary-grid">
    <!-- Recent Activity / Requests Table -->
    <div class="summary-card-box">
        <div class="summary-card-header">
            <h3>Recent Certificate Requests</h3>
            <a href="{{ route('certificates.page') }}" style="color: #059669; font-size: 0.85rem; font-weight: 600; text-decoration: none;">View All <i class="fa-solid fa-arrow-right" style="font-size: 0.75rem;"></i></a>
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
                        <td style="font-weight: 600;">{{ $request->resident_name }}</td>
                        <td>{{ $request->certificate_type }}</td>
                        <td>{{ $request->created_at->format('M d, Y') }}</td>
                        <td>
                            <span class="status-badge {{ $request->status == 'Approved' ? 'status-approved' : 'status-pending' }}">
                                <i class="fa-solid {{ $request->status == 'Approved' ? 'fa-circle-check' : 'fa-clock' }}"></i>
                                {{ $request->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td style="font-weight: 600;">Juan Dela Cruz</td>
                        <td>Barangay Clearance</td>
                        <td>Oct 20, 2026</td>
                        <td><span class="status-badge status-pending"><i class="fa-solid fa-clock"></i> Pending</span></td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Maria Santos</td>
                        <td>Certificate of Indigency</td>
                        <td>Oct 19, 2026</td>
                        <td><span class="status-badge status-approved"><i class="fa-solid fa-circle-check"></i> Approved</span></td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Antonio Luna</td>
                        <td>Barangay Residency</td>
                        <td>Oct 18, 2026</td>
                        <td><span class="status-badge status-approved"><i class="fa-solid fa-circle-check"></i> Approved</span></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Recent Announcements Feed -->
    <div class="summary-card-box">
        <div class="summary-card-header">
            <h3>Latest Announcements</h3>
            <a href="{{ route('announcements.page') }}" style="color: #059669; font-size: 0.85rem; font-weight: 600; text-decoration: none;">View All <i class="fa-solid fa-arrow-right" style="font-size: 0.75rem;"></i></a>
        </div>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @forelse($recentAnnouncements ?? [] as $announcement)
                <div style="padding: 12px; background: #f8fafc; border-radius: 10px; border-left: 4px solid #059669;">
                    <div style="font-weight: 600; font-size: 0.875rem; color: #1e293b;">{{ $announcement->title }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">
                        <i class="fa-regular fa-clock" style="color: #059669; margin-right: 4px;"></i>{{ $announcement->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <div style="padding: 12px; background: #f8fafc; border-radius: 10px; border-left: 4px solid #059669;">
                    <div style="font-weight: 600; font-size: 0.875rem; color: #1e293b;">Community Cleanup Drive</div>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;"><i class="fa-regular fa-clock" style="color: #059669; margin-right: 4px;"></i>Posted 2 hours ago</div>
                </div>
                <div style="padding: 12px; background: #f8fafc; border-radius: 10px; border-left: 4px solid #10b981;">
                    <div style="font-weight: 600; font-size: 0.875rem; color: #1e293b;">Free Health Checkup Schedule</div>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;"><i class="fa-regular fa-clock" style="color: #059669; margin-right: 4px;"></i>Posted Yesterday</div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Chart.js Library & Green-Only Chart Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Bar Chart: Monthly Barangay Operations (Green Shades Only)
        const activityCanvas = document.getElementById('barangayActivityChart');
        if (activityCanvas) {
            new Chart(activityCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                    datasets: [
                        {
                            label: 'Certificates Issued',
                            data: [8, 12, 10, 15, 11, {{ (int)($certRequests ?? 3) }}],
                            backgroundColor: '#059669',
                            borderRadius: 6,
                            barPercentage: 0.55
                        },
                        {
                            label: 'Residents Registered',
                            data: [4, 6, 5, 9, 7, {{ (int)($totalResidents ?? 10) }}],
                            backgroundColor: '#6ee7b7',
                            borderRadius: 6,
                            barPercentage: 0.55
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { usePointStyle: true, boxWidth: 8, color: '#334155' }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: { color: '#64748b' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#64748b' }
                        }
                    }
                }
            });
        }

        // 2. Doughnut Chart: Records Distribution (Green Shades Only)
        const distCanvas = document.getElementById('recordsDistributionChart');
        if (distCanvas) {
            new Chart(distCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Residents', 'Certificates', 'Announcements', 'Blotter Records'],
                    datasets: [{
                        data: [
                            {{ (int)($totalResidents ?? 10) }},
                            {{ (int)($certRequests ?? 3) }},
                            {{ (int)($announcementsCount ?? 4) }},
                            {{ (int)($blotterCount ?? 2) }}
                        ],
                        backgroundColor: [
                            '#064e3b', // Deep Forest Green
                            '#059669', // Emerald Green
                            '#34d399', // Mint Green
                            '#a7f3d0'  // Soft Light Green
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '66%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { usePointStyle: true, padding: 14, boxWidth: 8, color: '#334155' }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection