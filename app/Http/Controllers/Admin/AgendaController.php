<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        // TODO: $agendas = Agenda::orderBy('date')->get();
        return view('admin.agenda.index');
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        // TODO: validasi + Agenda::create($request->validated());
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        // TODO: $agenda = Agenda::findOrFail($id);
        return view('admin.agenda.show', compact('id'));
    }

    public function edit(string $id)
    {
        // TODO: $agenda = Agenda::findOrFail($id);
        return view('admin.agenda.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: validasi + $agenda->update($request->validated());
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        // TODO: Agenda::findOrFail($id)->delete();
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}