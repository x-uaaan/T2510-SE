<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        return Inertia::render('posts/PostList');
    }

    public function create()
    {
        return Inertia::render('posts/PostCreate');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'postTitle' => 'required|string|max:255',
            'postDesc' => 'required',
            'alumniID' => 'required|integer|exists:alumni,alumniID',
            'forumID' => 'required|integer|exists:forums,forumID',
        ]);

        Post::create($validatedData);
        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        $post->load('alumni');
        $comments = [];
        if ($post->comment) {
            $comments = json_decode($post->comment, true);
        }
        return Inertia::render('posts/PostShow', [
            'post' => [
                'postTitle' => $post->postTitle,
                'postDesc' => $post->postDesc,
                'author' => $post->alumni ? $post->alumni->alumniName : 'Unknown',
                'comments' => $comments,
            ]
        ]);
    }

    public function edit(Post $post)
    {
        return Inertia::render('posts/PostEdit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'postTitle' => 'required|string|max:255',
            'postDesc' => 'required',
        ]);

        $post->update($validatedData);
        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }

    public function apiIndex(Request $request)
    {
        $forumId = $request->query('forum_id');
        $query = Post::query();
        
        if ($forumId) {
            $query->where('forumID', $forumId);
        }
        
        $posts = $query->orderBy('timestamp', 'desc')->get();
        return response()->json($posts);
    }
}