<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, DesaController, KlasterController, ProgramController, IndikatorController, TargetController, CapaianController, UserController, DashboardController, AjaxController, LaporanMasterController, DirectoryController};

// Root redirect ke dashboard (atau login jika belum auth)
Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Toggle Privacy (Direktori)
    Route::post('/privacy/toggle', [DirectoryController::class, 'togglePrivacy'])->name('privacy.toggle');

    // Semua role bisa akses Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/trend-program', [DashboardController::class, 'trendProgram'])->name('dashboard.trend.program');
    Route::get('/dashboard/trend-desa', [DashboardController::class, 'trendDesa'])->name('dashboard.trend.desa');

    // Hanya ADMIN yang bisa kelola User
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('user', UserController::class);
    });

    // ADMIN dan PJ_PROGRAM bisa kelola Master Data selain User
    Route::middleware(['role:admin,pj_program'])->group(function () {
        Route::resource('desa', DesaController::class);
        Route::resource('klaster', KlasterController::class);
        Route::resource('program', ProgramController::class);
        Route::get('/indikator/cetak', [IndikatorController::class, 'cetakPdf'])->name('indikator.cetak');
        Route::resource('indikator', IndikatorController::class);
        Route::resource('target', TargetController::class);
    });

    // Semua role (termasuk STAFF_DESA) bisa kelola Capaian
    Route::middleware(['role:admin,pj_program,staff_desa'])->group(function () {
        // Reporting Routes (Enhanced)
        Route::prefix('laporan/capaian')->group(function () {
            Route::get('/', [LaporanMasterController::class, 'index'])->name('capaian.laporan');
            Route::get('/data', [LaporanMasterController::class, 'getData'])->name('capaian.laporan.data');
            Route::get('/programs/{id_klaster}', [LaporanMasterController::class, 'getPrograms'])->name('capaian.laporan.programs');
            Route::get('/indikators/{id_program}', [LaporanMasterController::class, 'getIndikators'])->name('capaian.laporan.indikators');
            Route::get('/export/pdf', [LaporanMasterController::class, 'exportPdf'])->name('capaian.laporan.export.pdf');
            Route::get('/export/excel', [LaporanMasterController::class, 'exportExcel'])->name('capaian.laporan.export.excel');
            Route::get('/cetak', [LaporanMasterController::class, 'exportPdf'])->name('capaian.cetak');
        });

        Route::get('capaian/import', [CapaianController::class, 'formImport'])->name('capaian.import');
        Route::post('capaian/import', [CapaianController::class, 'importExcel'])->name('capaian.import.process');
        Route::get('capaian/template', [CapaianController::class, 'downloadTemplate'])->name('capaian.template');
        Route::resource('capaian', CapaianController::class);
    });

    // AJAX Routes for Cascading Dropdowns
    Route::get('/api/programs/{id_klaster}', [AjaxController::class, 'getPrograms'])->name('api.programs');
    Route::get('/api/indikators/{id_program}', [AjaxController::class, 'getIndikators'])->name('api.indikators');
    Route::get('/api/targets/{id_indikator}', [AjaxController::class, 'getTargets'])->name('api.targets');
    Route::get('/api/sisa-target/{id_target}/{id_desa}/{current_capaian_id?}', [AjaxController::class, 'getSisaTarget'])->name('api.sisa_target');
});