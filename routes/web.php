<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\RequestHelpController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [RequestHelpController::class, 'form']);
Route::post('/submit', [RequestHelpController::class, 'submit']);
Route::get('/riwayat', [RequestHelpController::class, 'riwayat'])->name('user.riwayat');
Route::prefix('admin')->group(function () {
    // Route::get('/dashboard-admin', function () {
    //     return view('admin.dashboard');
    // });
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])
        ->middleware('restrict.admin.ip')
        ->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])
        ->middleware('restrict.admin.ip')
        ->name('admin.login.submit');
});
Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/history', [AdminController::class, 'history'])->name('admin.history');
    Route::post('/admin/update/{id}', [AdminController::class, 'update']);
    Route::get('/admin/ip-mapping', [AdminController::class, 'ipMapping']);
    Route::post('/admin/ip-mapping', [AdminController::class, 'storeIpMapping']);
    Route::get('/admin/ip-mapping', [AdminController::class, 'ipMapping'])->name('admin.ip-mapping');
    Route::post('/admin/ip-mapping', [AdminController::class, 'storeIpMapping']);
    Route::get('/admin/ip-mapping/{id}/edit', [AdminController::class, 'editIpMapping'])->name('admin.ip-mapping.edit');
    Route::put('/admin/ip-mapping/{id}', [AdminController::class, 'updateIpMapping'])->name('admin.ip-mapping.update');
    Route::delete('/admin/ip-mapping/{id}', [AdminController::class, 'destroyIpMapping'])->name('admin.ip-mapping.destroy');
    Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
    Route::get('/admin/ip-mapping', [AdminController::class, 'ipMapping'])->name('admin.ip-mapping');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});
