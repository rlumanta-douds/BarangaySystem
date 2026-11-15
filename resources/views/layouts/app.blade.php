<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management System</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background-color: #f8fafc; color: #1e293b; display: flex; height: 100vh; overflow: hidden; }

        /* Sidebar Styling */
        .sidebar { width: 260px; background-color: #064e3b; color: white; display: flex; flex-direction: column; flex-shrink: 0; }
        .sidebar-brand { padding: 25px 20px; font-size: 1.25rem; font-weight: 700; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-nav { padding: 20px 0; display: flex; flex-direction: column; gap: 5px; flex-grow: 1; overflow-y: auto; }
        
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #cbd5e1; text-decoration: none; font-size: 0.95rem; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background-color: #047857; color: white; }
        .nav-link i { width: 20px; text-align: center; }

        /* Main Wrapper */
        .main-wrapper { flex-grow: 1; display: flex; flex-direction: column; height: 100vh; overflow: hidden; }
        
        /* Top Navbar */
        .top-navbar { height: 70px; background: white; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; flex-shrink: 0; z-index: 10; }
        .top-navbar .title { font-weight: 600; color: #334155; font-size: 1rem; }
        .user-dropdown { display: flex; align-items: center; gap: 10px; font-weight: 600; color: #1e293b; font-size: 0.9rem; }

        /* Content Area Fix */
        .content-area { flex-grow: 1; overflow-y: auto; background-color: #f8fafc; padding: 30px; }

        /* ========================================================
           DASHBOARD & CARDS STYLING (FOR 1-LINE HORIZONTAL LAYOUT)
           ======================================================== */
        
        /* 4 Stat Cards in 1 Row */
        .stat-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        /* Card Icon Theme Colors */
        .stat-icon.residents { background-color: #d1fae5; color: #059669; }
        .stat-icon.certificates { background-color: #dbeafe; color: #2563eb; }
        .stat-icon.announcements { background-color: #fef3c7; color: #d97706; }
        .stat-icon.blotter { background-color: #fee2e2; color: #dc2626; }

        .stat-info .stat-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #64748b;
            margin-bottom: 4px;
        }

        .stat-info .stat-value {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1;
        }

        /* Section Heading */
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 16px;
        }

        /* 5 Quick Nav Items in 1 Row */
        .quick-nav-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 16px;
        }

        .quick-nav-btn {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 18px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            color: #1e293b;
            font-size: 0.9rem;
            font-weight: 600;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
            transition: all 0.2s ease;
        }

        .quick-nav-btn:hover {
            border-color: #10b981;
            color: #047857;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.1);
        }

        .quick-nav-btn i {
            color: #10b981;
            font-size: 0.95rem;
            transition: transform 0.2s;
        }

        .quick-nav-btn:hover i {
            transform: translateX(3px);
        }

        /* Responsive behavior for smaller screens */
        @media (max-width: 1200px) {
            .stat-cards-grid { grid-template-columns: repeat(2, 1fr); }
            .quick-nav-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 640px) {
            .stat-cards-grid, .quick-nav-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-building-shield" style="color: #86efac;"></i> Barangay System
        </div>
        <div class="sidebar-nav">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <!-- Admin Sidebar -->
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
                <a href="{{ route('residents.page') }}" class="nav-link {{ request()->routeIs('residents.page') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i> Residents
                </a>
                <a href="{{ route('certificates.page') }}" class="nav-link {{ request()->routeIs('certificates.page') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-lines"></i> Certificates
                </a>
                <a href="{{ route('announcements.page') }}" class="nav-link {{ request()->routeIs('announcements.page') ? 'active' : '' }}">
                    <i class="fa-solid fa-bullhorn"></i> Announcements
                </a>
                <a href="{{ route('blotter.page') }}" class="nav-link {{ request()->routeIs('blotter.page') ? 'active' : '' }}">
                    <i class="fa-solid fa-shield-halved"></i> Blotter Records
                </a>
                <a href="{{ route('reports.page') }}" class="nav-link {{ request()->routeIs('reports.page') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-shield"></i> Reports
                </a>
            @else
                <!-- Resident Sidebar -->
                <a href="{{ route('resident.dashboard') }}" class="nav-link {{ request()->routeIs('resident.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
                <a href="{{ route('resident.profile') }}" class="nav-link {{ request()->routeIs('resident.profile') ? 'active' : '' }}">
                    <i class="fa-solid fa-user"></i> My Profile
                </a>
                <a href="{{ route('resident.certificates') }}" class="nav-link {{ request()->routeIs('resident.certificates') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-lines"></i> Certificates
                </a>
                <a href="{{ route('resident.announcements') }}" class="nav-link {{ request()->routeIs('resident.announcements') ? 'active' : '' }}">
                    <i class="fa-solid fa-bullhorn"></i> Announcements
                </a>
                <a href="{{ route('resident.history') }}" class="nav-link {{ request()->routeIs('resident.history') ? 'active' : '' }}">
                    <i class="fa-solid fa-clock-rotate-left"></i> Request History
                </a>
                <a href="{{ route('resident.contact') }}" class="nav-link {{ request()->routeIs('resident.contact') ? 'active' : '' }}">
                    <i class="fa-solid fa-headset"></i> Contact Us
                </a>
            @endif

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" style="margin-top: auto; padding: 20px;">
                @csrf
                <button type="submit" class="nav-link" style="background: none; border: none; width: 100%; cursor: pointer; color: #fca5a5; text-align: left;">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="title">Overview & Management Panel</div>
            <div class="user-dropdown">
                <i class="fa-solid fa-circle-user" style="font-size: 1.2rem; color: #16a34a;"></i>
                {{ auth()->user()->name ?? 'Head Administrator' }}
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @hasSection('content')
                @yield('content')
            @else
                <!-- DEFAULT DASHBOARD VIEW IF NO BLADE INHERITANCE USED -->
                
                <!-- 1 ROW STAT CARDS -->
                <div class="stat-cards-grid">
                    <div class="stat-card">
                        <div class="stat-icon residents">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">Total Residents</div>
                            <div class="stat-value">{{ $totalResidents ?? '10' }}</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon certificates">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">Certificate Requests</div>
                            <div class="stat-value">{{ $certRequests ?? '3' }}</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon announcements">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">Announcements</div>
                            <div class="stat-value">{{ $announcementsCount ?? '4' }}</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon blotter">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-label">Blotter Records</div>
                            <div class="stat-value">{{ $blotterCount ?? '3' }}</div>
                        </div>
                    </div>
                </div>

                <!-- QUICK NAVIGATION SECTION -->
                <div class="section-title">Quick Navigation</div>
                
                <div class="quick-nav-grid">
                    <a href="{{ route('residents.page') }}" class="quick-nav-btn">
                        <span>Manage Residents</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('certificates.page') }}" class="quick-nav-btn">
                        <span>Issue Certificates</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('announcements.page') }}" class="quick-nav-btn">
                        <span>Post Announcement</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('blotter.page') }}" class="quick-nav-btn">
                        <span>View Blotter Complaints</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('reports.page') }}" class="quick-nav-btn">
                        <span>Generate Reports</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

</body>
</html>