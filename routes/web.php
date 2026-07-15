<?php

use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route publik
|--------------------------------------------------------------------------
| Nama-nama route di bawah ini SENGAJA disamakan dengan field 'route' di
| config/navigation.php. Kalau nambah menu baru di navbar, tambahkan juga
| route-nya di sini (atau di file fitur terpisah, lihat pola di bawah).
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// --- Tentang Kami ---
Route::get('/tentang/sejarah', fn () => view('committee.history'))->name('about.history');
Route::get('/tentang/struktur-komite', fn () => view('committee.structure'))->name('about.structure');
Route::get('/tentang/struktur-komite/{param}', fn ($param) => view('committee.structure-show', compact('param')))->name('committee-structure.show');
Route::get('/tentang/struktur-tim-teknis', fn () => view('committee.technical-team'))->name('about.technical-team');
Route::get('/tentang/tim-teknis/{param}', fn ($param) => view('committee.technical-team-show', compact('param')))->name('technical-team.show');
Route::get('/tentang/tugas', fn () => view('committee.tasks'))->name('about.tasks');

// --- Proses Baku ---
Route::get('/proses/tahapan', fn () => view('revisions.stages'))->name('process.stages');
Route::get('/proses/konsultasi-publik', fn () => view('revisions.public-consultation'))->name('process.public-consultation');
Route::get('/proses/pengesahan', fn () => view('revisions.ratification'))->name('process.ratification');

// --- Produk dan Referensi ---
Route::get('/produk', fn () => view('documents.index'))->name('products.index');
Route::get('/produk/ifpp', fn () => view('documents.ifpp'))->name('products.ifpp');
Route::get('/produk/isa', fn () => view('documents.isa'))->name('products.isa');
Route::get('/produk/spap', fn () => view('documents.spap'))->name('products.spap');
Route::get('/produk/standar-audit-lain', fn () => view('documents.other-audit'))->name('products.other-audit');
Route::get('/produk/standar-penugasan-lain', fn () => view('documents.other-assignment'))->name('products.other-assignment');
Route::get('/perpustakaan', fn () => view('documents.library'))->name('library.index');

// --- Menu utama lainnya ---
Route::get('/berita', fn () => view('home.news'))->name('news.index');
Route::get('/forum', fn () => view('forum.index'))->name('forum.index');
Route::get('/agenda', fn () => view('agenda.index'))->name('agenda.index');
Route::get('/statistik', fn () => view('home.stats'))->name('stats.index');

require __DIR__.'/admin.php';  // route panel admin, terpisah dari route publik di atas