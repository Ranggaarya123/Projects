<?php

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
// FA Controller
use App\Http\Controllers\FA\DashboardController as FADashboardController;
use App\Http\Controllers\FA\ApprovalBrevetController;
use App\Http\Controllers\FA\StatusBrevetController as FAStatusBrevetController;
// HCM Controller
use App\Http\Controllers\HCM\DashboardController as HCMDashboardController;
use App\Http\Controllers\HCM\ApprovalController as HCMApprovalController;
use App\Http\Controllers\HCM\ApprovalAktivasiNIKController;
use App\Http\Controllers\HCM\ApprovalNonaktifNIKController;
use App\Http\Controllers\HCM\ApprovalMutasiController;
use App\Http\Controllers\HCM\ApprovalCreateMitraController;
use App\Http\Controllers\HCM\StatusBrevetController as HCMStatusBrevetController;
use App\Http\Controllers\HCM\StatusHCMController;

use App\Http\Controllers\HCM\ImportExcelController;
// User Controller
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\CreateAktivasiMYISCMTController as UserCreateAktivasiMYISCMTController;
use App\Http\Controllers\User\DuplicateWHController as UserDuplicateWHController;
use App\Http\Controllers\User\PindahWHController as UserPindahWHController;
use App\Http\Controllers\User\ValidasiTacticalController as UserValidasiTacticalController;
use App\Http\Controllers\User\StatusController as UserStatusController;
// Performance Controller
use App\Http\Controllers\Performance\DashboardController as PerformanceDashboardController;
use App\Http\Controllers\Performance\ApprovalValidasiTacticalController;
use App\Http\Controllers\Performance\ApprovalCreateAktivasiMYISCMTController;
use App\Http\Controllers\Performance\ApprovalDuplicateWHController;
use App\Http\Controllers\Performance\ApprovalPindahWHController;
use App\Http\Controllers\Performance\StatusPerformanceController;
use App\Http\Controllers\Performance\StatusBrevetController as PerformanceStatusBrevetController;
// Mitra Controller
use App\Http\Controllers\Mitra\DashboardController as MitraDashboardController;
use App\Http\Controllers\Mitra\BrevetController as MitraBrevetController;
use App\Http\Controllers\Mitra\CreateMitraController as MitraCreateMitraController;
use App\Http\Controllers\Mitra\AktivasiNIKController as MitraAktivasiNIKController;
use App\Http\Controllers\Mitra\NonAktifNIKController as MitraNonAktifNIKController;
use App\Http\Controllers\Mitra\MutasiController as MitraMutasiController;
use App\Http\Controllers\Mitra\StatusBrevetController as MitraStatusBrevetController;
use App\Http\Controllers\Mitra\StatusCreateMitraController as MitraStatusCreateMitraController;
use App\Http\Controllers\Mitra\StatusMitraController as MitraStatusMitraController;
// Others
use App\Http\Middleware\CheckAuth;
use Illuminate\Support\Facades\Route;

//Add pengguna baru
use App\Http\Controllers\UserController;
Route::get('/auth/create-user', [UserController::class, 'create'])->name('user.create');
Route::post('/auth/store-user', [UserController::class, 'store'])->name('user.store');
Route::post('/auth/verify-user', [UserController::class, 'verify'])->name('user.verify.post');


Route::get('/', function () {
    // return view('welcome');
    return redirect('/auth/login');
});

Route::prefix('/auth')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'loginAction']);
    Route::get('/logout', [LoginController::class, 'logoutAction']);
    Route::post('/verify', [LoginController::class, 'verifyAction']);


    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware([CheckAuth::class])->group(function () {
    Route::prefix('/fa')->group(function () {
        Route::get('/', [FADashboardController::class, 'index'])->name('dashboardFA');
        // Approval Brevet
        Route::get('/approval/brevet', [ApprovalBrevetController::class, 'index']);
        Route::post('/approval/brevet/{id}', [ApprovalBrevetController::class, 'approve']);
        //Status Brevet
        Route::get('/status/status_brevet', [FAStatusBrevetController::class, 'index']);
    });

    Route::prefix('/hcm')->group(function () {
        Route::get('/', [HCMDashboardController::class, 'index'])->name('dashboardHCM');
        // Approval Aktivasi NIK
        Route::get('/approval/aktivasi-nik', [ApprovalAktivasiNIKController::class, 'index']);
        Route::post('/approval/aktivasi-nik/{id}', [ApprovalAktivasiNIKController::class, 'approve']);
        // Approval Nonaktif NIK
        Route::get('/approval/nonaktif-nik', [ApprovalNonaktifNIKController::class, 'index']);
        Route::post('/approval/nonaktif-nik/{id}', [ApprovalNonaktifNIKController::class, 'approve']);
        // Approval Mutasi
        Route::get('/approval/mutasi', [ApprovalMutasiController::class, 'index']);
        Route::post('/approval/mutasi/{id}', [ApprovalMutasiController::class, 'approve']);
        // Approval Create NIK
        Route::get('/approval/create-mitra', [ApprovalCreateMitraController::class, 'index']);
        Route::post('/approval/create-mitra/{id}', [ApprovalCreateMitraController::class, 'approve']);
        //Edit Delete Mitra Employee
        Route::get('/mitra-manajemen/edit/{id}', [HCMDashboardController::class, 'edit'])->name('mitra-manajemen.edit-hcm');
        Route::post('/mitra-manajemen/update/{id}', [HCMDashboardController::class, 'update'])->name('mitra-manajemen.update-hcm');
        Route::delete('/mitra-manajemen/delete/{id}', [HCMDashboardController::class, 'destroy'])->name('mitra-manajemen.destroy-hcm');
        // Add Mitra Employee
        Route::get('/mitra-manajemen/create', [HCMDashboardController::class, 'create'])->name('mitra-manajemen.create-hcm');
        Route::post('/mitra-manajemen', [HCMDashboardController::class, 'store'])->name('mitra-manajemen.store-hcm');
        // tampil status brevet
        Route::get('/status/status_brevet', [HCMStatusBrevetController::class, 'index']);
        // tampil status hcm
        Route::get('/status/statushcm', [StatusHCMController::class, 'index']);
        Route::get('/hcm/statushcm', [StatusHCMController::class, 'index'])->name('status.indexhcm');
        //Impor excel
        Route::post('/', [HCMDashboardController::class, 'import'])->name('import.excel-hcm');
        // Route untuk menampilkan halaman upload Excel
        Route::get('/mitra-manajemen/import-excel', [HCMDashboardController::class, 'showUploadForm'])->name('mitra-manajemen.import-excel-hcm');

    });

    Route::prefix('/user')->group(function () {
        Route::get('/', [UserDashboardController::class, 'index'])->name('dashboardUser');
        // Aktivasi MYI Create MYI Aktivasi SCMT  Create SCMT
        Route::get('/ca-myiscmt', [UserCreateAktivasiMYISCMTController::class, 'index']);
        Route::post('/ca-myiscmt', [UserCreateAktivasiMYISCMTController::class, 'store']);
        // Pindah WH
        Route::get('/pindah-wh', [UserPindahWHController::class, 'index']);
        Route::post('/pindah-wh', [UserPindahWHController::class, 'store']);
        // Duplicate WH
        Route::get('/duplicate-wh', [UserDuplicateWHController::class, 'index']);
        Route::post('/duplicate-wh', [UserDuplicateWHController::class, 'store']);
        // Validasi Tactical
        Route::get('/validasi-tactical', [UserValidasiTacticalController::class, 'index']);
        Route::post('/validasi-tactical', [UserValidasiTacticalController::class, 'store']);

        Route::get('/status/status', [UserStatusController::class, 'index']);
        Route::get('/user/status', [UserStatusController::class, 'index'])->name('status.indexuser');
    });

    Route::prefix('/mitra')->group(function () {
        Route::get('/', [MitraDashboardController::class, 'index'])->name('dashboardMitra');
        // Brevet Routes
        Route::get('/brevet', [MitraBrevetController::class, 'index']);
        Route::post('/brevet', [MitraBrevetController::class, 'store']);
        // Create Mitra
        Route::get('/upload/create-mitra', [MitraCreateMitraController::class, 'index']);
        Route::post('/upload/create-mitra', [MitraCreateMitraController::class, 'store']);
        // Aktivasi NIK
        Route::get('/upload/aktivasi-nik', [MitraAktivasiNIKController::class, 'index']);
        Route::post('/upload/aktivasi-nik', [MitraAktivasiNIKController::class, 'store']);
        // Non Aktif NIK
        Route::get('/upload/nonaktif-nik', [MitraNonAktifNIKController::class, 'index']);
        Route::post('/upload/nonaktif-nik', [MitraNonAktifNIKController::class, 'store']);
        // Mutasi
        Route::get('/upload/mutasi', [MitraMutasiController::class, 'index']);
        Route::post('/upload/mutasi', [MitraMutasiController::class, 'store']);
        // Status
        Route::get('/status/status_brevet', [MitraStatusBrevetController::class, 'index']);
        Route::post('/brevet/upload/{id}', [MitraStatusBrevetController::class, 'uploadSertifikat'])->name('brevet.upload');
        Route::get('/status/status_createmitra', [MitraStatusCreateMitraController::class, 'index']);
        Route::get('/status/status', [MitraStatusMitraController::class, 'index']);
        Route::get('/mitra/status', [MitraStatusMitraController::class, 'index'])->name('status.indexmitra');
    });

    Route::prefix('/performance')->group(function() {
        //Dashboard
        Route::get('/', [PerformanceDashboardController::class, 'index'])->name('dashboardPerformance');
        // Approval Validasi Tactical
        Route::get('/validasi-tactical', [ApprovalValidasiTacticalController::class, 'index']);
        Route::post('/validasi-tactical/{id}', [ApprovalValidasiTacticalController::class, 'approve']);
        // Approval Aktivasi MYI Aktivasi SCMT Creat MYI Creat SCMT
        Route::get('/ca-myiscmt', [ApprovalCreateAktivasiMYISCMTController::class, 'index']);
        Route::post('/ca-myiscmt/{id}', [ApprovalCreateAktivasiMYISCMTController::class, 'approve']);
        // Approval Duplicate WH
        Route::get('/duplicate-wh', [ApprovalDuplicateWHController::class, 'index']);
        Route::post('/duplicate-wh/{id}', [ApprovalDuplicateWHController::class, 'approve']);
        // Approval Pindah WH
        Route::get('/pindah-wh', [ApprovalPindahWHController::class, 'index']);
        Route::post('/pindah-wh/{id}', [ApprovalPindahWHController::class, 'approve']);
        //Status
        Route::get('/status/statusperformance', [StatusPerformanceController::class, 'index']);
        Route::get('/performance/statusperformance', [StatusPerformanceController::class, 'index'])->name('status.indexperformance');
        // tampil status brevet
        Route::get('/status/status_brevet', [performanceStatusBrevetController::class, 'index']);

        //Edit Delete Mitra Employee
        Route::get('/mitra-manajemen/edit/{id}', [PerformanceDashboardController::class, 'edit'])->name('mitra-manajemen.edit-performance');
        Route::post('/mitra-manajemen/update/{id}', [PerformanceDashboardController::class, 'update'])->name('mitra-manajemen.update-performance');
        Route::delete('/mitra-manajemen/delete/{id}', [PerformanceDashboardController::class, 'destroy'])->name('mitra-manajemen.destroy-performance');
        // Add Mitra Employee
        Route::get('/mitra-manajemen/create', [PerformanceDashboardController::class, 'create'])->name('mitra-manajemen.create-performance');
        Route::post('/mitra-manajemen', [PerformanceDashboardController::class, 'store'])->name('mitra-manajemen.store-performance');
        //Add Exccel
        Route::post('/', [PerformanceDashboardController::class, 'import'])->name('import.excel-performance');
        // Route untuk menampilkan halaman upload Excel
        Route::get('/mitra-manajemen/import-excel', [PerformanceDashboardController::class, 'showUploadForm'])->name('mitra-manajemen.import-excel-performance');
    });
});

?>
