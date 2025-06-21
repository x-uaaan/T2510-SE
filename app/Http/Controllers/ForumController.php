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
        $validated = $request->validate([
            'forumTitle' => 'required|string|max:255',
            'forumDesc' => 'required|string',
            'Categories' => 'nullable|string',
            'organiserID' => 'required|string',
            'organiserName' => 'required|string',
        ]);
        // Generate new forumID
        $lastForum = Forum::orderBy('forumID', 'desc')->first();
        $lastIdNumber = $lastForum ? (int) substr($lastForum->forumID, 4) : 0;
        $newId = 'frm_' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);

        $forum = Forum::create([
            'forumID' => $newId,
            'forumTitle' => $validated['forumTitle'],
            'forumDesc' => $validated['forumDesc'],
            'Categories' => $validated['Categories'],
            'organiserID' => $validated['organiserID'],
            'organiserName' => $validated['organiserName'],
        ]);
        return response()->json(['success' => true, 'forum' => $forum]);
    }

    public function show(Forum $forum)
    {
        $forum->load(['posts.user', 'user']);

        return Inertia::render('posts/PostShow', [
            'forum' => $forum,
            'posts' => $forum->posts,
        ]);
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
        $forums = Forum::with('organiser')->withCount('posts')->orderBy('forumID', 'desc')->get();
        return response()->json($forums);
    }

    public function apiShow(Forum $forum)
    {
        return response()->json($forum);
    }

    public function apiDestroy(Forum $forum)
    {
        $forum->delete();
        return response()->json(['success' => true, 'message' => 'Forum deleted successfully.']);
    }

    public function apiUpdate(Request $request, Forum $forum)
    {
        $validatedData = $request->validate([
            'forumTitle' => 'required|string|max:255',
            'forumDesc' => 'required|string',
            'Categories' => 'nullable|string',
        ]);

        $forum->update($validatedData);

        return response()->json(['success' => true, 'forum' => $forum]);
    }
}