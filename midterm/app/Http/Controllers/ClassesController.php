<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('create-class')) {
            return Inertia::render('ClassList', ['subjects' => fn() => Subject::with('users')->latest()->paginate(2)]);
        } else {
            return Inertia::render('ClassList', ['subjects' => fn() => Subject::latest()->paginate(2)]);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('CreateClass');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Gate::allows('create-class')) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'credit' => 'required|numeric'
        ]);

        $subject = new Subject();
        $subject->name = $request->name;
        $subject->description = $request->description;
        $subject->credit = $request->credit;
        $subject->save();

        return Redirect::route('classes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $subject = Subject::find($id);
        // return Inertia::render('ShowClass', ['subject' => $subject]);

        return Inertia::render(
            'ShowClass',
            [
                'subject' => fn() => Subject::find($id),
                'registeredClass' => fn() => auth()->user()->subjects->contains($id),
            ]
        );
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'credit' => 'required|numeric'
        ]);
        $subject = Subject::find($id);

        $subject->name = $request->name;
        $subject->credit = $request->credit;
        $subject->description = $request->description;

        $subject->save();

        return Redirect::route('classes.show', ['classId' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::find($id);

        $subject->delete();

        return Redirect::route('classes');
    }

    public function register($id) {
        auth()->user()->subjects()->toggle($id);

        return Redirect::route('classes.show', ['classId' => $id]);
    }

    public function index_cr() {
        auth()->user()->load('subjects.users');

        return Inertia::render('classesRegistered', ['subject' => fn() => auth()->user()->subjects]);
    }

    public function users($id) {
        if (!Gate::allows('view-registered-users')) {
            abort(403);
        }

        return Inertia::render('ClassUsers', ['users' => fn() => Subject::find($id)->users()->paginate(2)]);
    }
}
