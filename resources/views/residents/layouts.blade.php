
You sent
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Residents Portal') | Barangay System</title>

    {{-- Keep your existing background and styles --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/residents.css') }}">
</head>
<body>
    <header class="resident-header">
        <div>
            <h2>Barangay Management System</h2>
            <p>Residents Portal</p>
        </div>
        <span class="resident-badge">Resident</span>
    </header>

    <nav class="resident-nav">
        <a href="{{ route('resident.dashboard') }}">Dashboard</a>
        <a href="{{ route('resident.profile') }}">My Profile</a>
        <a href="{{ route('resident.certificates') }}">Certificates</a>
        <a href="{{ route('resident.announcements') }}">Announcements</a>
        <a href="{{ route('resident.history') }}">Request History</a>
        <a href="{{ route('resident.contact') }}">Contact Us</a>
    </nav>

    <main class="resident-container">
        @if (session('success'))
            <div class="resident-alert">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="resident-footer">
        &copy; {{ date('Y') }} Barangay Management System. All rights reserved.
    </footer>
</body>
</html>