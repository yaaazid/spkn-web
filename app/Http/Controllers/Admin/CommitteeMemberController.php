<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommitteeMemberController extends Controller
{
    public function index()
    {
        // TODO: $members = CommitteeMember::orderBy('name')->get();
        return view('admin.members.index');
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        // TODO: validasi + CommitteeMember::create($request->validated());
        return redirect()->route('admin.anggota-komite.index')->with('success', 'Anggota komite berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        // TODO: $member = CommitteeMember::findOrFail($id);
        return view('admin.members.show', compact('id'));
    }

    public function edit(string $id)
    {
        // TODO: $member = CommitteeMember::findOrFail($id);
        return view('admin.members.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: validasi + $member->update($request->validated());
        return redirect()->route('admin.anggota-komite.index')->with('success', 'Anggota komite berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        // TODO: CommitteeMember::findOrFail($id)->delete();
        return redirect()->route('admin.anggota-komite.index')->with('success', 'Anggota komite berhasil dihapus.');
    }
}