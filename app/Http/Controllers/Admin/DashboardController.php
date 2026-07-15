<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // Cuma butuh index() — di routes/admin.php ini dipanggil lewat
    // Route::get('/', [DashboardController::class, 'index'])->name('dashboard'),
    // bukan Route::resource, jadi tidak perlu create/store/edit/update/destroy.
    public function index()
    {
        // TODO: ambil ringkasan data untuk kartu statistik dashboard, contoh:
        // $totalDocuments = Document::count();
        // $totalMembers   = CommitteeMember::count();
        // $upcomingAgenda = Agenda::where('date', '>=', now())->count();

        return view('admin.dashboard');
    }
}