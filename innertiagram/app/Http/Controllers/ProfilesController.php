<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {
        $user = User::where('name', $name)->first();

        if ($user)
            return Inertia::render('Dashboard', [
                'user' => $user,
                'posts' => $user->posts,
                'can' => ['create_update' => Auth::user()->id == $user->id],
                'viewed_user' => $user,
                'followers' => $user->profile->followers->count(),
            ]);
        else
            return Inertia::render('Notfound');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        // Auth::user()->profile->update($data);
        $profile = new Profile();
        $profile->user_id = Auth::user()->id;
        $profile->title = $request->title;
        $profile->description = $request->description;
        $profile->save();

        return Inertia::render('Dashboard', [
            'user' => fn() => Auth::user(),
            'posts' => fn() => Auth::user()->posts,
            'can' => ['create_update' => true],
            'viewed_user' => Auth::user(),
            'followers' => $user->profile->followers->count(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
