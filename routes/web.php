<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;

// Route::get('/welcome', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });



// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::get('/', function (ProfileController $users) {
    return Inertia::render('Profili', [
        'users' => $users->fetchUsers()
    ]);
});

Route::get('/profili/{param}', function (ProfileController $users, $param) {
    return Inertia::render('Profili', [
        'users' => $users->fetchMoreUsers($param)
    ]);
});

Route::get('/profilo/{param}', function (ProfileController $users, $username) {
    return Inertia::render('Profili', [
        'user' => $users->fetchUserDetails($username)
    ]);
});

require __DIR__.'/auth.php';
