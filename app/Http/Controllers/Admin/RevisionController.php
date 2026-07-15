<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RevisionController extends Controller
{
    public function index()
    {
        // TODO: $revisions = SpknRevision::orderBy('revised_at', 'desc')->get();
        return view('admin.revisions.index');
    }

    public function create()
    {
        return view('admin.revisions.create');
    }

    public function store(Request $request)
    {
        // TODO: validasi + SpknRevision::create($request->validated());
        return redirect()->route('admin.revisi-spkn.index')->with('success', 'Revisi SPKN berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        // TODO: $revision = SpknRevision::findOrFail($id);
        return view('admin.revisions.show', compact('id'));
    }

    public function edit(string $id)
    {
        // TODO: $revision = SpknRevision::findOrFail($id);
        return view('admin.revisions.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: validasi + $revision->update($request->validated());
        return redirect()->route('admin.revisi-spkn.index')->with('success', 'Revisi SPKN berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        // TODO: SpknRevision::findOrFail($id)->delete();
        return redirect()->route('admin.revisi-spkn.index')->with('success', 'Revisi SPKN berhasil dihapus.');
    }
}