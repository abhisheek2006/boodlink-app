<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\BloodGroupController;
use App\Http\Controllers\Admin\BloodStockController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationSessionController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::view('/', 'home')->name('home');

/*
|--------------------------------------------------------------------------
| Guest routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/register/donor', [AuthController::class, 'showDonorRegister'])->name('register.donor');
    Route::post('/register/donor', [AuthController::class, 'registerDonor'])->name('register.donor.post');
    Route::get('/register/patient', [AuthController::class, 'showPatientRegister'])->name('register.patient');
    Route::post('/register/patient', [AuthController::class, 'registerPatient'])->name('register.patient.post');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated routes (any role)
|--------------------------------------------------------------------------
| `active` (EnsureAccountIsActive) sits on top of `auth` so banned or
| suspended users are logged out immediately on any request.
*/
Route::middleware(['auth', 'active'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::delete('/profile/photo', [ProfileController::class, 'removePhoto'])->name('profile.photo.remove');

    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Chat is shared between donor and patient participants; ChatController
    // itself checks that the current user belongs to the session.
    Route::get('/chat/{session}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{session}/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{session}/fetch', [ChatController::class, 'fetch'])->name('chat.fetch');

    /*
    |----------------------------------------------------------------------
    | Admin routes
    |----------------------------------------------------------------------
    */
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        Route::get('/analytics/blood-group-distribution', [AnalyticsController::class, 'bloodGroupDistribution'])->name('analytics.blood-groups');
        Route::get('/analytics/monthly-donations', [AnalyticsController::class, 'monthlyDonations'])->name('analytics.monthly-donations');
        Route::get('/analytics/monthly-requests', [AnalyticsController::class, 'monthlyRequests'])->name('analytics.monthly-requests');
        Route::get('/analytics/availability', [AnalyticsController::class, 'availabilityBreakdown'])->name('analytics.availability');
        Route::get('/analytics/top-cities', [AnalyticsController::class, 'topCities'])->name('analytics.top-cities');

        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/activate', [UserManagementController::class, 'activate'])->name('users.activate');
        Route::patch('/users/{user}/deactivate', [UserManagementController::class, 'deactivate'])->name('users.deactivate');
        Route::patch('/users/{user}/suspend', [UserManagementController::class, 'suspend'])->name('users.suspend');
        Route::patch('/users/{user}/unsuspend', [UserManagementController::class, 'unsuspend'])->name('users.unsuspend');
        Route::patch('/users/{user}/ban', [UserManagementController::class, 'ban'])->name('users.ban');
        Route::patch('/users/{user}/unban', [UserManagementController::class, 'unban'])->name('users.unban');
        Route::post('/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.reset-password');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

        /*
        | Mail Composer
        |--------------------------------------------------------------------------
        |  Save templates (GET index / POST store / POST send). Admin-only.
        */
        Route::get('/mail', [MailController::class, 'index'])->name('mail.index');
        Route::get('/mail/create', [MailController::class, 'create'])->name('mail.create');
        Route::post('/mail/templates', [MailController::class, 'storeTemplate'])->name('mail.templates.store');
        Route::post('/mail/send', [MailController::class, 'send'])->name('mail.send');
        Route::get('/mail/{template}', [MailController::class, 'show'])->name('mail.show');
        Route::delete('/mail/{template}', [MailController::class, 'destroyTemplate'])->name('mail.templates.destroy');

        Route::get('/blood-groups', [BloodGroupController::class, 'index'])->name('blood-groups.index');
        Route::post('/blood-groups', [BloodGroupController::class, 'store'])->name('blood-groups.store');
        Route::put('/blood-groups/{bloodGroup}', [BloodGroupController::class, 'update'])->name('blood-groups.update');
        Route::patch('/blood-groups/{bloodGroup}/activate', [BloodGroupController::class, 'activate'])->name('blood-groups.activate');
        Route::patch('/blood-groups/{bloodGroup}/deactivate', [BloodGroupController::class, 'deactivate'])->name('blood-groups.deactivate');
        Route::delete('/blood-groups/{bloodGroup}', [BloodGroupController::class, 'destroy'])->name('blood-groups.destroy');

        Route::get('/blood-stocks', [BloodStockController::class, 'index'])->name('blood-stocks.index');
        Route::post('/blood-stocks', [BloodStockController::class, 'store'])->name('blood-stocks.store');
        Route::put('/blood-stocks/{bloodStock}', [BloodStockController::class, 'update'])->name('blood-stocks.update');
        Route::delete('/blood-stocks/{bloodStock}', [BloodStockController::class, 'destroy'])->name('blood-stocks.destroy');

        Route::get('/chats', [ChatController::class, 'adminIndex'])->name('chats.index');
        Route::get('/chats/{session}', [ChatController::class, 'adminShow'])->name('chats.show');

        Route::get('/blood-requests', [BloodRequestController::class, 'adminIndex'])->name('blood-requests.index');
        Route::get('/blood-requests/{bloodRequest}', [BloodRequestController::class, 'adminShow'])->name('blood-requests.show');

        Route::get('/donations', [DonationSessionController::class, 'adminIndex'])->name('donations.index');
        Route::get('/donations/{session}', [DonationSessionController::class, 'adminShow'])->name('donations.show');

        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::post('/settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [ReportController::class, 'preview'])->name('reports.preview');
        Route::get('/reports/{report}/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
        Route::get('/reports/{report}/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
    });

    /*
    |----------------------------------------------------------------------
    | Donor routes
    |----------------------------------------------------------------------
    */
    Route::middleware('donor')->prefix('donor')->name('donor.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'donor'])->name('dashboard');
        Route::get('/history', [DonorController::class, 'history'])->name('history');

        Route::get('/requests', [BloodRequestController::class, 'incoming'])->name('requests.index');
        Route::patch('/requests/{bloodRequest}/reject', [BloodRequestController::class, 'reject'])->name('requests.reject');

        // Accept is gated by cooldown + one-active-session enforcement.
        Route::patch('/requests/{bloodRequest}/accept', [BloodRequestController::class, 'accept'])
            ->middleware('donation.eligibility')
            ->name('requests.accept');

        Route::patch('/sessions/{session}/complete', [DonationSessionController::class, 'complete'])->name('sessions.complete');
        Route::patch('/sessions/{session}/end', [DonationSessionController::class, 'end'])->name('sessions.end');
        Route::patch('/sessions/{session}/share-contact', [DonationSessionController::class, 'shareContact'])->name('sessions.share-contact');
    });

    /*
    |----------------------------------------------------------------------
    | Patient routes
    |----------------------------------------------------------------------
    */
    Route::middleware('patient')->prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'patient'])->name('dashboard');

        Route::get('/search', [DonorController::class, 'search'])->name('search');

        Route::get('/requests', [BloodRequestController::class, 'index'])->name('requests.index');
        Route::get('/donors/{donor}/request', [BloodRequestController::class, 'create'])->name('requests.create');
        Route::post('/donors/{donor}/request', [BloodRequestController::class, 'store'])->name('requests.store');
        Route::patch('/requests/{bloodRequest}/cancel', [BloodRequestController::class, 'cancel'])->name('requests.cancel');
    });
});
