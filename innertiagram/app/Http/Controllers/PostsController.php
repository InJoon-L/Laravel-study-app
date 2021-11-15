<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostsController extends Controller
{
    public function create() {
        return Inertia::render('Instagram/CreatePostForm');
    }

    public function store(Request $req) {
        $data = $req->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);

        return Inertia::render('Dashboard', ['user' => auth()->user(), 'posts' => Auth::user()->posts]);
    }
}
