<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientPasswordController;
use App\Http\Controllers\FinancialDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InternalApplicationsController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\NoticeInteractionController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// ✅ Dashboard – only ONE route now
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'permission:dashboard.view'])
    ->name('dashboard');

// ✅ Internal Applications
Route::get('/internal-applications', [InternalApplicationsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('internal.apps');

// ✅ Wealixir Policies Handbook
Route::get('/wealixir-policies', function () {
    return view('wealixir_policies');
})->middleware(['auth', 'verified'])->name('wealixir.policies');


// ✅ Profile routes
Route::middleware(['auth', 'permission:profile.view'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});
Route::middleware(['auth', 'permission:profile.update'])->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::middleware(['auth', 'permission:profile.delete'])->group(function () {
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Client routes
Route::middleware(['auth', 'permission:clients.create'])->group(function () {
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
});
Route::middleware(['auth', 'permission:clients.view'])->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
});
Route::middleware(['auth', 'permission:clients.update'])->group(function () {
    Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
});
Route::middleware(['auth', 'permission:clients.delete'])->group(function () {
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
});

// ✅ Client Passwords
Route::middleware(['auth', 'permission:client_passwords.view'])->prefix('clients/{clientId}/passwords')->group(function () {
    Route::get('/', [ClientPasswordController::class, 'index'])->name('client_passwords.index');
    Route::post('/{passwordId}/reveal', [ClientPasswordController::class, 'reveal'])
        ->middleware(['password.confirm', 'throttle:password-reveal'])
        ->name('client_passwords.reveal');
});
Route::middleware(['auth', 'permission:client_passwords.create'])->prefix('clients/{clientId}/passwords')->group(function () {
    Route::get('/create', [ClientPasswordController::class, 'create'])->name('client_passwords.create');
    Route::post('/', [ClientPasswordController::class, 'store'])->name('client_passwords.store');
});
Route::middleware(['auth', 'permission:client_passwords.update'])->prefix('clients/{clientId}/passwords')->group(function () {
    Route::get('/{passwordId}/edit', [ClientPasswordController::class, 'edit'])->name('client_passwords.edit');
    Route::put('/{passwordId}', [ClientPasswordController::class, 'update'])->name('client_passwords.update');
});
Route::middleware(['auth', 'permission:client_passwords.delete'])->prefix('clients/{clientId}/passwords')->group(function () {
    Route::delete('/{passwordId}', [ClientPasswordController::class, 'destroy'])->name('client_passwords.destroy');
});

// ✅ Financial Data
Route::middleware(['auth', 'permission:financial_data.view'])->prefix('clients/{clientId}/financial-data')->group(function () {
    Route::get('/', [FinancialDataController::class, 'index'])->name('client_financial_data.index');
});
Route::middleware(['auth', 'permission:financial_data.create'])->prefix('clients/{clientId}/financial-data')->group(function () {
    Route::get('/create', [FinancialDataController::class, 'create'])->name('client_financial_data.create');
    Route::post('/', [FinancialDataController::class, 'store'])->name('client_financial_data.store');
});
Route::middleware(['auth', 'permission:financial_data.update'])->prefix('clients/{clientId}/financial-data')->group(function () {
    Route::put('/{financialDataId}', [FinancialDataController::class, 'update'])->name('client_financial_data.update');
});
Route::middleware(['auth', 'permission:financial_data.view'])->group(function () {
    Route::get('/financial-data', [FinancialDataController::class, 'index'])->name('financial_data.index');
});
Route::middleware(['auth', 'permission:financial_data.update'])->group(function () {
    Route::get('/financial-data/{client}/edit', [FinancialDataController::class, 'edit'])->name('financial_data.edit');
});

// ✅ Import Excel
Route::middleware(['auth', 'permission:import.view'])->group(function () {
    Route::get('/client_import', [ImportController::class, 'showUploadForm'])->name('import.form');
});
Route::middleware(['auth', 'permission:import.create'])->group(function () {
    Route::post('/client_import', [ImportController::class, 'import'])->name('import.excel');
});

// ✅ Admin: User management
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/notices', [NoticeBoardController::class, 'index'])->name('notices.index');
    Route::post('/notices', [NoticeBoardController::class, 'store'])->name('notices.store');
    Route::put('/notices/{notice}', [NoticeBoardController::class, 'update'])->name('notices.update');
    Route::delete('/notices/{notice}', [NoticeBoardController::class, 'destroy'])->name('notices.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/notices/{notice}/like', [NoticeInteractionController::class, 'toggleLike'])->name('notices.like');
    Route::post('/notices/{notice}/comments', [NoticeInteractionController::class, 'storeComment'])->name('notices.comments.store');
    Route::delete('/notices/comments/{comment}', [NoticeInteractionController::class, 'destroyComment'])->name('notices.comments.destroy');
    Route::get('/notices/{notice}/comments', [NoticeInteractionController::class, 'index'])->name('notices.comments.index');
});

// ✅ Audit logs
Route::middleware(['auth', 'permission:audit_logs.view'])->group(function () {
    Route::get('/audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audit_logs.index');
    Route::get('/audit-logs/{auditLog}', [\App\Http\Controllers\Admin\AuditLogController::class, 'show'])->name('audit_logs.show');
});

require __DIR__.'/auth.php';
