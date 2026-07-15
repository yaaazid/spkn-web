<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteStat;
use Illuminate\Http\Request;

class SiteStatController extends Controller
{
    // Route::resource('statistik', ...)->only(['index', 'edit', 'update'])
    // di routes/admin.php — jadi cuma 3 method ini yang perlu ada.

    public function index()
    {
        $stats = SiteStat::orderBy('order')->get();
        return view('admin.statistik.index', compact('stats'));
    }

    public function edit(string $id)
    {
        $stat = SiteStat::findOrFail($id);
        return view('admin.statistik.edit', compact('stat'));
    }

    public function update(Request $request, string $id)
    {
        $stat = SiteStat::findOrFail($id);

        $validated = $request->validate([
            'icon'  => 'required|string|max:60',
            'value' => 'required|string|max:30',
            'label' => 'required|string|max:100',
            'order' => 'nullable|integer',
        ]);

        $stat->update($validated);

        return redirect()->route('admin.statistik.index')->with('success', 'Statistik berhasil diperbarui.');
    }
}