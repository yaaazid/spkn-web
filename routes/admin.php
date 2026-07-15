<?php

use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\CommitteeMemberController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\ForumController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RevisionController;
use App\Http\Controllers\Admin\SiteStatController;
use Illuminate\Support\Facades\Route;

// Situs ini informatif, tanpa sistem login/autentikasi. Panel admin diakses
// langsung lewat /admin — tidak diproteksi middleware apa pun untuk saat ini.
// Kalau nanti perlu dibatasi (mis. cuma tim internal), tinggal tambahkan lagi
// ->middleware([...]) di sini setelah sistem auth-nya siap.
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('menu', MenuController::class);
        Route::resource('anggota-komite', CommitteeMemberController::class);
        Route::resource('dokumen', DocumentController::class);
        Route::resource('forum', ForumController::class);
        Route::resource('agenda', AgendaController::class);
        Route::resource('revisi-spkn', RevisionController::class);
        Route::resource('statistik', SiteStatController::class)->only(['index', 'edit', 'update']);
    });