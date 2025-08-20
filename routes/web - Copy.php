<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\TeamInviteController;

// Public home page
Route::get('/', function () {
    return view('welcome');
});

// SuperAdmin Dashboard (default /dashboard)
Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'is_superadmin'])
    ->name('dashboard');


// Auth routes (login, register, password, etc.)
require __DIR__ . '/auth.php';


// All routes below require authentication
Route::middleware('auth')->group(function () {

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // SuperAdmin Routes for managing clients
    Route::middleware('is_superadmin')->group(function () {
        Route::get('/superadmin/clients', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/superadmin/clients/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/superadmin/clients', [ClientController::class, 'store'])->name('clients.store');
    });

    // Admin Routes
    Route::middleware('role:Admin')->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Team invitation by Admin
        Route::post('/team/invite', [TeamInviteController::class, 'store'])->name('team.invite');

        // URL Shortener routes for Admin
        Route::prefix('urls')->name('urls.')->group(function () {
            Route::get('/', [UrlController::class, 'index'])->name('index');
            Route::get('/create', [UrlController::class, 'create'])->name('create');
            Route::post('/', [UrlController::class, 'store'])->name('store');
        });
    });

    // Member Routes
    Route::middleware('role:Member')->group(function () {
        Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])->name('member.dashboard');

        // URL Shortener routes for Member
        Route::prefix('urls')->name('urls.')->group(function () {
            Route::get('/', [UrlController::class, 'index'])->name('index');
            Route::get('/create', [UrlController::class, 'create'])->name('create');
            Route::post('/', [UrlController::class, 'store'])->name('store');
        });
    });
});


// Public redirect route for short URLs (no auth)
Route::get('/{short_url}', [UrlController::class, 'redirect'])
    ->where('short_url', '[A-Za-z0-9]+')
    ->name('short.redirect');
