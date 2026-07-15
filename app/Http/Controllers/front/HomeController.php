<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SiteStat;

class HomeController extends Controller
{
    public function index()
    {
        $stats = SiteStat::orderBy('order')
            ->get(['icon', 'value', 'label'])
            ->toArray();

        // Fallback kalau tabel site_stats masih kosong di awal development,
        // supaya hero tetap tampil normal.
        if (empty($stats)) {
            $stats = [
                ['icon' => 'bi-people-fill', 'value' => '1.500+', 'label' => 'Pengunjung Bulan Ini'],
                ['icon' => 'bi-file-earmark-text-fill', 'value' => '120+', 'label' => 'Dokumen SPKN'],
            ];
        }

        return view('home.index', compact('stats'));
    }
}