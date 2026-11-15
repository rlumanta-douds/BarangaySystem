<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background-color: #064e3b;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 22px 0;
            flex-shrink: 0;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 22px 24px 22px;
            font-size: 1.2rem;
            font-weight: 700;
            color: #ffffff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand i {
            color: #6ee7b7;
            font-size: 1.35rem;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 20px;
            padding: 0 12px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            color: #d1fae5;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .sidebar-nav a i {
            color: #6ee7b7;
            width: 18px;
            text-align: center;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: #047857;
            color: #ffffff;
            font-weight: 600;
        }

        /* Logout Button (Strictly Green) */
        .sidebar-footer {
            padding: 16px 22px 0 22px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-btn {
            background: none;
            border: none;
            color: #6ee7b7;
            font-size: 0.92rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 4px;
            transition: color 0.2s ease;
        }

        .logout-btn:hover {
            color: #a7f3d0;
        }

        /* Main Area */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar {
            background-color: #ffffff;
            height: 64px;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
        }

        .topbar-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #334155;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e293b;
        }

        .topbar-user i {
            color: #059669;
            font-size: 1.15rem;
        }

        .content-area {
            padding: 28px 30px;
            flex: 1;
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div>
            <div class="sidebar-brand">
                <i class="fa-solid fa-building-shield"></i>
                <span>Barangay System</span>
            </div>

            <nav class="sidebar-nav">
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <!-- ADMIN PORTAL SIDEBAR -->
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('residents.page') }}" class="{{ request()->routeIs('residents.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i>
                        <span>Residents</span>
                    </a>
                    <a href="{{ route('certificates.page') }}" class="{{ request()->routeIs('certificates.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>Certificates</span>
                    </a>
                    <a href="{{ route('announcements.page') }}" class="{{ request()->routeIs('announcements.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bullhorn"></i>
                        <span>Announcements</span>
                    </a>
                    <a href="{{ route('blotter.page') }}" class="{{ request()->routeIs('blotter.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Blotter Records</span>
                    </a>
                    <a href="{{ route('reports.page') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-contract"></i>
                        <span>Reports</span>
                    </a>
                @else
                    <!-- RESIDENT PORTAL SIDEBAR -->
                    <a href="{{ route('resident.dashboard') }}" class="{{ request()->routeIs('resident.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('resident.profile') }}" class="{{ request()->routeIs('resident.profile*') ? 'active' : '' }}">
                        <i class="fa-solid fa-id-card"></i>
                        <span>Profile View</span>
                    </a>
                    <a href="{{ route('resident.certificates') }}" class="{{ request()->routeIs('resident.certificates*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>Certificate Request</span>
                    </a>
                    <a href="{{ route('resident.announcements') }}" class="{{ request()->routeIs('resident.announcements*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bullhorn"></i>
                        <span>Announcement</span>
                    </a>
                    <a href="{{ route('resident.history') }}" class="{{ request()->routeIs('resident.history') ? 'active' : '' }}">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>Request History</span>
                    </a>
                @endif
            </nav>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-title">
                {{ (auth()->check() && auth()->user()->role === 'admin') ? 'Overview & Management Panel' : 'Resident Portal' }}
            </div>
            <div class="topbar-user">
                <i class="fa-solid fa-circle-user"></i>
                <span>{{ auth()->user()->name ?? 'User' }}</span>
            </div>
        </header>

        <main class="content-area">
            @yield('content')
        </main>
    </div>

</body>
</html>