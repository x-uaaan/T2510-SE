<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::all();
        return view('forums.index', compact('forums'));
    }

    public function create()
    {
        return view('forums.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'forumTitle' => 'required|string|max:255',
            'forumDesc' => 'required',
        ]);

        Forum::create($validatedData);
        return redirect()->route('forums.index')->with('success', 'Forum created successfully!');
    }

    public function show(Forum $forum)
    {
        return view('forums.show', compact('forum'));
    }

    public function edit(Forum $forum)
    {
        return view('forums.edit', compact('forum'));
    }

    public function update(Request $request, Forum $forum)
    {
        $validatedData = $request->validate([
            'forumTitle' => 'required|string|max:255',
            'forumDesc' => 'required',
        ]);

        $forum->update($validatedData);
        return redirect()->route('forums.index')->with('success', 'Forum updated successfully!');
    }

    public function destroy(Forum $forum)
    {
        $forum->delete();
        return redirect()->route('forums.index')->with('success', 'Forum deleted successfully!');
    }
}