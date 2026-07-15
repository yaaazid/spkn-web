<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        // TODO: $documents = Document::latest()->get();
        return view('admin.documents.index');
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        // TODO: validasi (termasuk upload file) + Document::create($request->validated());
        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        // TODO: $document = Document::findOrFail($id);
        return view('admin.documents.show', compact('id'));
    }

    public function edit(string $id)
    {
        // TODO: $document = Document::findOrFail($id);
        return view('admin.documents.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: validasi + $document->update($request->validated());
        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        // TODO: Document::findOrFail($id)->delete(); // hapus juga file fisiknya
        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}