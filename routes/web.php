<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Admin Controller Imports
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ResidentController as AdminResidentController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\BlotterController as AdminBlotterController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

// Resident Controller Imports
use App\Http\Controllers\residents\dashboardController as ResidentDashboardController;
use App\Http\Controllers\residents\profileController as ProfileController;
use App\Http\Controllers\residents\certificatesController as ResidentCertificateController;
use App\Http\Controllers\residents\announcementsController as ResidentAnnouncementController;
use App\Http\Controllers\residents\requestsController as RequestHistoryController;
use App\Http\Controllers\residents\contactusController as ContactController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'resident') {
            return redirect()->route('resident.dashboard');
        }

        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard');
        }

        Auth::logout();
    }

    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Find user manually with trimmed email to prevent whitespace mismatch
    $user = \App\Models\User::where('email', trim($request->email))->first();

    if (!$user) {
        return back()->withErrors([
            'email' => 'No user found with this email address in the database.',
        ])->onlyInput('email');
    }

    // Verify the password hash safely
    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'email' => 'The password you entered does not match our records.',
        ])->onlyInput('email');
    }

    // Authenticate and log the user in session
    Auth::login($user);
    $request->session()->regenerate();

    // Route based on role
    if ($user->role === 'admin') {
        return redirect()->route('dashboard');
    }

    if ($user->role === 'resident') {
        return redirect()->route('resident.dashboard');
    }

    Auth::logout();

    return back()->withErrors([
        'email' => 'Your account does not have a valid portal role assigned.',
    ])->onlyInput('email');
})->name('login.submit');

// Registration Routes for Unlimited Resident Sign-Ups
Route::get('/register', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->role === 'admin' ? 'dashboard' : 'resident.dashboard');
    }
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);

    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'resident', // Automatically assign resident role
    ]);

    // Auto-login the user immediately upon registration
    Auth::login($user);

    // Redirect straight to the resident dashboard seamlessly
    return redirect()->route('resident.dashboard');
})->name('register.submit');

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| Admin Portal Routes (Protected by role:admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Resident Management Routes
    Route::get('/residents', [AdminResidentController::class, 'index'])->name('residents.page');
    Route::post('/residents', [AdminResidentController::class, 'store'])->name('residents.store');
    Route::put('/residents/{id}', [AdminResidentController::class, 'update'])->name('residents.update');
    Route::delete('/residents/{id}', [AdminResidentController::class, 'destroy'])->name('residents.destroy');

    // Certificate Management Routes
    Route::get('/certificates', [AdminCertificateController::class, 'index'])->name('certificates.page');
    Route::post('/certificates', [AdminCertificateController::class, 'store'])->name('certificates.store');
    Route::put('/certificates/{id}', [AdminCertificateController::class, 'update'])->name('certificates.update');
    Route::delete('/certificates/{id}', [AdminCertificateController::class, 'destroy'])->name('certificates.destroy');

    // Announcement Management Routes
    Route::get('/announcements', [AdminAnnouncementController::class, 'index'])->name('announcements.page');
    Route::post('/announcements', [AdminAnnouncementController::class, 'store'])->name('announcements.store');
    Route::put('/announcements/{id}', [AdminAnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{id}', [AdminAnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // Blotter Management Routes
    Route::get('/blotter', [AdminBlotterController::class, 'index'])->name('blotter.page');
    Route::post('/blotter', [AdminBlotterController::class, 'store'])->name('blotter.store');
    Route::put('/blotter/{id}', [AdminBlotterController::class, 'update'])->name('blotter.update');
    Route::delete('/blotter/{id}', [AdminBlotterController::class, 'destroy'])->name('blotter.destroy');

    // Reports Page Route
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.page');
});


/*
|--------------------------------------------------------------------------
| Residents Portal Routes (Protected by role:resident)
|--------------------------------------------------------------------------
*/

Route::prefix('resident')
    ->name('resident.')
    ->middleware(['auth', 'role:resident'])
    ->group(function () {

        Route::get('/dashboard', [ResidentDashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/certificates', [ResidentCertificateController::class, 'index'])->name('certificates');
        Route::post('/certificates', [ResidentCertificateController::class, 'store'])->name('certificates.submit');

        Route::get('/announcements', [ResidentAnnouncementController::class, 'index'])->name('announcements');

        Route::get('/request-history', [RequestHistoryController::class, 'index'])->name('history');

        Route::get('/contact', [ContactController::class, 'index'])->name('contact');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');
    });


/*
|--------------------------------------------------------------------------
| Shared Authenticated Routes (Accessible by BOTH Admin & Resident)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,resident'])->group(function () {
    Route::get('/barangay-announcements', [ResidentAnnouncementController::class, 'index'])
        ->name('shared.announcements');
});