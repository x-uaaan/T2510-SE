<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Forum;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $forumId = $request->query('forum_id');
        $forum = null;
        $query = Post::with('user')->orderBy('timestamp', 'desc');

        if ($forumId) {
            $query->where('forumID', $forumId);
            $forum = Forum::find($forumId);
        }

        return Inertia::render('posts/PostList', [
            'posts' => $query->get(),
            'forum' => $forum,
        ]);
    }

    public function create()
    {
        return Inertia::render('posts/PostCreate');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'postTitle' => 'required|string|max:255',
            'postDesc' => 'required|string',
            'userID' => 'required|string|exists:users,userID',
            'forumID' => 'required|string|exists:forums,forumID',
        ]);

        // Generate new postID
        $lastPost = Post::orderBy('postID', 'desc')->first();
        $lastIdNumber = $lastPost ? (int) substr($lastPost->postID, 4) : 0;
        $newId = 'pst_' . str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);

        try {
            $post = Post::create([
                'postID' => $newId,
                'postTitle' => $validatedData['postTitle'],
                'postDesc' => $validatedData['postDesc'],
                'userID' => $validatedData['userID'],
                'forumID' => $validatedData['forumID'],
                'timestamp' => now(),
            ]);
            
            return response()->json(['success' => true, 'post' => $post], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Post creation failed.'], 500);
        }
    }

    public function show(Post $post)
    {
        $post->load('user');
        $comments = [];
        if ($post->comment) {
            $comments = json_decode($post->comment, true);
        }
        return Inertia::render('posts/PostShow', [
            'post' => [
                'postID' => $post->postID,
                'postTitle' => $post->postTitle,
                'postDesc' => $post->postDesc,
                'author' => $post->user ? $post->user->username : 'Unknown',
                'authorId' => $post->user ? $post->user->userID : null,
                'comments' => array_reverse($comments),
                'forumID' => $post->forumID,
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

    public function apiDestroy(Post $post)
    {
        $post->delete();
        return response()->json(['success' => true, 'message' => 'Post deleted successfully.']);
    }

    public function apiUpdate(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'postTitle' => 'required|string|max:255',
            'postDesc' => 'required|string',
        ]);

        $post->update($validatedData);

        return response()->json(['success' => true, 'post' => $post]);
    }

    public function apiIndex(Request $request)
    {
        $forumId = $request->query('forum_id');
        $query = Post::query();
        
        if ($forumId) {
            $query->where('forumID', $forumId);
        }
        
        $posts = $query->with('user')->orderBy('postID', 'desc')->get();
        return response()->json($posts);
    }

    public function addComment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
        ]);

        $comments = json_decode($post->comment, true) ?? [];
        $comments[] = $validated['comment'];

        $post->update(['comment' => json_encode($comments)]);

        return response()->json(['success' => true, 'comments' => array_reverse($comments)]);
    }
}