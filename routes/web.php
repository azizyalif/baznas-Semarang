<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\ArsipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\RekapController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'login');
Route::get('logout', [DashboardController::class, 'logout'])->name('logout');
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Tambahkan route khusus admin di sini
    // Contoh:
    // Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
});

Route::middleware(['auth:sanctum', 'role:operator'])->group(function () {
    // Tambahkan route khusus operator di sini
    // Contoh:
    // Route::get('/operator/dashboard', [DashboardController::class, 'operatorDashboard'])->name('operator.dashboard');
});

Route::middleware(['auth:sanctum', 'role:super_admin'])->group(function () {
    // Tambahkan route khusus super admin di sini
    // Contoh:
    // Route::get('/super-admin/dashboard', [DashboardController::class, 'superAdminDashboard'])->name('super_admin.dashboard');
});
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard', [DashboardController::class, 'index', 'getChartData'])->name('dashboard');
    Route::get('/proposal', [ProposalController::class, 'index'])->name('proposal');
    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip');
    Route::get('/rekap/index', [RekapController::class, 'index'])->name('rekap/index');
    Route::get('/rekap/program', [RekapController::class, 'rekapProgram'])->name('rekap/program');
    Route::get('/proposal/{id}/disposisi', [ProposalController::class, 'showDisposisi'])->name('proposal/disposisi');
    Route::get('/proposal/export/excel', [ProposalController::class, 'export_excel'])->name('proposal/export/excel');
    Route::get('/dibantu/export/excel', [ProposalController::class, 'dibantu_excel'])->name('dibantu/export/excel');
    Route::get('/arsip/export/excel', [ArsipController::class, 'export_excel'])->name('arsip/export/excel');
    Route::get('/rekap/export/excel', [RekapController::class, 'export_excel'])->name('rekap/export/excel');
    Route::get('/jenis/export/excel', [RekapController::class, 'jenis_excel'])->name('jenis/export/excel');
    Route::get('/proposal/create', [ProposalController::class, 'create'])->name('proposal/create');
    Route::get('/proposal/dibantu', [ProposalController::class, 'dibantu'])->name('proposal/dibantu');
    Route::get('/proposal/{id}/proses', [ProposalController::class, 'proses'])->name('proposal/proses');
    Route::get('/proposal/proses', [ProposalController::class, 'process'])->name('proposal/process');
    Route::post('/proposal/store', [ProposalController::class, 'store'])->name('proposal/store');
    Route::get('/proposal/{id}/edit', [ProposalController::class, 'edit'])->name('proposal/edit');
    Route::put('/proposal/update', [ProposalController::class, 'update'])->name('proposal/update');
    Route::put('/proposal/update/{id}', [ProposalController::class, 'update'])->name('proposal/update');
    Route::get('/proposal/delete/{id}', [ProposalController::class, 'delete'])->name('proposal/delete');
    Route::get('/arsip/delete/{id}', [ArsipController::class, 'delete'])->name('arsip/delete');
    Route::get('/proposal/clear', [ProposalController::class, 'destroy'])->name('proposal/clear');
    Route::get('/arsip/clear', [ArsipController::class, 'destroy'])->name('arsip/clear');
    Route::get('/proposal/print', [ProposalController::class, 'print'])->name('proposal/print');
    Route::get('/proposal/download', [ProposalController::class, 'download'])->name('proposal/download');
    Route::get('/rekap/jenis', [RekapController::class, 'rekapJenis'])->name('rekap/jenis');
    Route::get('/json-get-data-by-program', [DashboardController::class, 'getChartData']);
    Route::get('/json-get-data-by-kecamatan', [DashboardController::class, 'getChartData']);
    Route::get('/settings/account', [AkunController::class, 'index'])->name('account');
    Route::get('/settings/account/{id}/delete', [AkunController::class, 'destroy'])->name('settings/account/delete');
    Route::get('/settings/{id}/admin', [AkunController::class, 'admin'])->name('settings/admin');
    Route::get('/settings/{id}/super_admin', [AkunController::class, 'super_admin'])->name('settings/super_admin');
    Route::get('/settings/{id}/operator', [AkunController::class, 'operator'])->name('settings/operator');  

});
