<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // TODO: $menus = Menu::orderBy('order')->get();
        return view('admin.menu.index');
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        // TODO: validasi + Menu::create($request->validated());
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        // Tidak dipakai untuk menu (langsung ke edit), tapi wajib ada karena Route::resource.
        return redirect()->route('admin.menu.edit', $id);
    }

    public function edit(string $id)
    {
        // TODO: $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: validasi + $menu->update($request->validated());
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        // TODO: Menu::findOrFail($id)->delete();
        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}