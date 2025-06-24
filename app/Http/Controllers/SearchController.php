<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Forum;
use App\Models\Post;
use App\Models\Event;
use App\Models\User;

class SearchController extends Controller
{
    public function search(Request $request, $keyword)
    {
        $forums = Forum::where('forumTitle', 'like', "%{$keyword}%")->get(['forumID', 'forumTitle']);
        $posts = Post::where('postTitle', 'like', "%{$keyword}%")->get(['postID', 'postTitle', 'forumID']);
        $events = Event::where('eventName', 'like', "%{$keyword}%")->get(['eventID', 'eventName']);
        $users = User::where('username', 'like', "%{$keyword}%")->get(['userID', 'username']);

        return Inertia::render('SearchPage', [
            'keyword' => $keyword,
            'forums' => $forums,
            'posts' => $posts,
            'events' => $events,
            'users' => $users,
        ]);
    }
}
