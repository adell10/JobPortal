<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/hello', function () {
    return "Halo, ini halaman percobaan route!";
});

Route::get('/jobs', [JobController::class, 'index']);


Route::get('/dashboard', function () {
    $user = Auth::user();
    
    if (!$user) {
        return redirect()->route('login');
    }

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'jobseeker':
            return redirect()->route('jobseeker.dashboard');
        default:
            abort(403, 'Akses tidak diizinkan.');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');

    Route::get('/jobseeker/dashboard', function () {
        return view('dashboard.jobseeker');
    })->name('jobseeker.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin', function () {
    return "Halaman Admin!";
})->middleware(['auth', 'isAdmin']);

Route::get('/admin/jobs', function () {
    return view('admin.jobs');
})->middleware(['auth', 'isAdmin']);

require __DIR__.'/auth.php';