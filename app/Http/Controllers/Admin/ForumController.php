<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
        // TODO: $threads = Forum::withCount('replies')->latest()->get();
        return view('admin.forum.index');
    }

    public function create()
    {
        return view('admin.forum.create');
    }

    public function store(Request $request)
    {
        // TODO: validasi + Forum::create($request->validated());
        return redirect()->route('admin.forum.index')->with('success', 'Topik forum berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        // TODO: $thread = Forum::with('replies')->findOrFail($id);
        return view('admin.forum.show', compact('id'));
    }

    public function edit(string $id)
    {
        // TODO: $thread = Forum::findOrFail($id);
        return view('admin.forum.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // TODO: validasi + $thread->update($request->validated());
        return redirect()->route('admin.forum.index')->with('success', 'Topik forum berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        // TODO: Forum::findOrFail($id)->delete(); // cascade ke ForumReply
        return redirect()->route('admin.forum.index')->with('success', 'Topik forum berhasil dihapus.');
    }
}