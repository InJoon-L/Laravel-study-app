<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function index() {
        // 팔로우 중인 사용자의 아이디만 뽑아내자
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users)->get();
        // dd($posts);

        return Inertia::render('Home', [
            'user' => Auth::user(),
            'posts' => $posts,
        ]);

    }

    public function create() {
        return Inertia::render('Instagram/CreatePostForm');
    }

    public function store(Request $req) {
        $data = $req->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);

        return Inertia::render('Dashboard',
        [
            'user' => auth()->user(),
            'posts' => Auth::user()->posts,
            'can' => ['create_update' => true],
            'viewed_user' => Auth::user(),
            'followers' => auth()->user()->profile->followers->count(),
        ]);
    }
}
