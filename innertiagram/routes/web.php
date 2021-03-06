<?php

use App\Http\Controllers\FollowsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfilesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware(['auth:sanctum', 'verified'])->get('/', [PostsController::class, 'index'])->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render(
        'Dashboard',
        [
            'user' => auth()->user(),
            'posts' => Auth::user()->posts,
            'can' => ['create_update' => true],
            'viewed_user' => Auth::user(),
            'followers' => Auth::user()->profile->followers->count(),
        ]);
})->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])->get('/profiles/{name}', [ProfilesController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->get('/post/create', [PostsController::class, 'create'])->name('post.create');
Route::middleware(['auth:sanctum', 'verified'])->post('/post/store', [PostsController::class, 'store'])->name('post.store');
Route::middleware(['auth:sanctum', 'verified'])->patch('/profiles/update', [ProfilesController::class, 'update'])->name('profile.update');
Route::middleware(['auth:sanctum', 'verified'])->post('/follow/{user}', [FollowsController::class, 'store'])->name('follow.store');
