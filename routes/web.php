<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/{username}', [UserProfileController::class,'show'])->name('userprofile.show');
});


// Public Routes
// Route::get('/', [PostController::class,'index'])->name('post.index');//or a dedicated home controller
Route::get('/posts', [PostController::class,'index'])->name('post.index');
//authenticated routes
Route::middleware(['auth', 'verified'])->group(function() {
     // Route to display the post creation form (handled by Inertia)
    Route::get('/posts/create', [PostController::class,'create'])->name('post.create');
    
    // Route to handle the actual form submission (POST request)
    Route::post('/posts', [PostController::class,'store'])->name('post.store');
    Route::get('/posts/{post}/edit', [PostController::class,'edit'])->name('post.edit');
    Route::put('/posts/{post}', [PostController::class,'update'])->name('post.update'); // use PUT//PATCH for update
    Route::delete('/posts/{post}', [PostController::class,'destroy'])->name('post.destroy');
});
Route::get('/posts/{post}', [PostController::class,'show'])->name('post.show');

require __DIR__.'/auth.php';
