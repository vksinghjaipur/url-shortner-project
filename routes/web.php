<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\ShortUrlRedirectController;

Route::get('/', function () {
    return view('welcome');
});

// SuperAdmin Dashboard
Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'is_superadmin'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // SuperAdmin Routes
    Route::middleware('is_superadmin')->group(function () {
        Route::get('/superadmin/clients', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/superadmin/clients/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/superadmin/clients', [ClientController::class, 'store'])->name('clients.store');

         //CSV download route for Super Admin only
        Route::get('/urls/download', [UrlController::class, 'download'])->name('urls.download');
    });

    
    // Admin Dashboard
    Route::middleware('role:Admin')->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Admin inviting team members
        Route::post('/team/invite', [TeamInviteController::class, 'store'])->name('team.invite');

        Route::get('/admin/download-urls', [AdminDashboardController::class, 'downloadUrlsCsv'])->name('admin.download.urls');

    });  


    // Member Dashboard
    Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])
        ->middleware('role:Member')
        ->name('member.dashboard');

    // URL Shortener Routes
    Route::prefix('urls')->name('urls.')->group(function () {
        Route::get('/', [UrlController::class, 'index'])->name('index');
        Route::get('/create', [UrlController::class, 'create'])->name('create');
        Route::post('/', [UrlController::class, 'store'])->name('store');
        
    });
});


require __DIR__.'/auth.php';

Route::get('/{short_url}', [UrlController::class, 'redirect'])
    ->where('short_url', '[A-Za-z0-9]+')
    ->name('short.redirect');
