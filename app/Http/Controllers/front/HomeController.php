<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SiteStat;
use Illuminate\Database\QueryException;

class HomeController extends Controller
{
    public function index()
    {
        $stats = $this->fallbackStats();

        // Dibungkus try/catch, bukan cuma cek empty(), supaya kalau tabel
        // site_stats belum sempat di-migrate (mis. project baru di-clone),
        // halaman tetap tampil dengan data default alih-alih 500 error.
        try {
            $dbStats = SiteStat::orderBy('order')->get(['value', 'label'])->toArray();

            if (! empty($dbStats)) {
                $stats = $dbStats;
            }
        } catch (QueryException $e) {
            report($e); // tetap tercatat di log, cuma tidak menghentikan request
        }

        return view('home.index', compact('stats'));
    }

    private function fallbackStats(): array
    {
        return [
            ['value' => '2017', 'label' => 'Sejak dibentuk'],
            ['value' => '4', 'label' => 'Unsur komite'],
            ['value' => '7/8', 'label' => 'Tahap proses baku'],
        ];
    }
}