<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::all();
        return view('forum.index', compact('forums'));
    }

    public function create()
    {
        return view('forum.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'forumTitle' => 'required|string|max:255',
            'forumDesc' => 'required',
        ]);

        Forum::create($validatedData);
        return redirect()->route('forum.index')->with('success', 'Forum created successfully!');
    }

    public function show(Forum $forum)
    {
        return view('forum.show', compact('forum'));
    }

    public function edit(Forum $forum)
    {
        return view('forum.edit', compact('forum'));
    }

    public function update(Request $request, Forum $forum)
    {
        $validatedData = $request->validate([
            'forumTitle' => 'required|string|max:255',
            'forumDesc' => 'required',
        ]);

        $forum->update($validatedData);
        return redirect()->route('forum.index')->with('success', 'Forum updated successfully!');
    }

    public function destroy(Forum $forum)
    {
        $forum->delete();
        return redirect()->route('forum.index')->with('success', 'Forum deleted successfully!');
    }

    public function apiIndex()
    {
        $forums = Forum::withCount('posts')->get();
        return response()->json($forums);
    }
}