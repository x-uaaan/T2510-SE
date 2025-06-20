<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use Inertia\Inertia;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::all();
        return view('forum.index', compact('forums'));
    }

    public function create()
    {
        return Inertia::render('ForumCreateForm');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'forumTitle' => 'required|string|max:255',
            'forumDesc' => 'required',
            'Categories' => 'nullable|string|max:255',
            'organiserId' => 'required',
            'organiserName' => 'required|string|max:255',
        ]);

        $forum = new Forum();
        $forum->forumTitle = $validatedData['forumTitle'];
        $forum->forumDesc = $validatedData['forumDesc'];
        $forum->Categories = $validatedData['Categories'] ?? null;
        $forum->organiserID = $validatedData['organiserId'];
        $forum->organiser = $validatedData['organiserName'];
        $forum->save();

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Forum created successfully.'], 201);
        }
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
        $forums = Forum::all();
        return response()->json($forums);
    }
}