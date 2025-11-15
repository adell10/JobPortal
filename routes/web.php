<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/hello', function () {
    return "Halo, ini halaman percobaan route!";
});

// Daftar lowongan kerja
Route::get('/jobs', [JobController::class, 'index']);

// Redirect dashboard sesuai role user
Route::get('/dashboard', function () {
    $user = Auth::user();
    if (!$user) { return redirect()->route('login');}

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'jobseeker':
            return redirect()->route('jobseeker.dashboard');
        default:
            abort(403, 'Akses tidak diizinkan.');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Dashboard per role
Route::middleware(['auth', 'verified'])->group(function () {
    // Admin
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard');

    // Jobseeker
    Route::get('/jobseeker/dashboard', function () {
        return view('dashboard.jobseeker');
    })->name('jobseeker.dashboard');
});
 
// Manajemen profil user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Halaman admin (testing middleware)
Route::get('/admin', function () {
    return "Halaman Admin!";
})->middleware(['auth', 'isAdmin']);

// Redirect ke halaman kelola lowongan admin
Route::get('/admin/jobs', function () {
    return redirect()->route('jobs.index');
})->middleware(['auth', 'isAdmin']);

// Import data lowongan dari file excel
Route::post('/jobs/import', [JobController::class,
'import'])->name('jobs.import')->middleware('isAdmin');

// Menampilkan daftar lowongan & detail (untuk semua user login)
Route::resource('jobs', JobController::class)
->only(['index', 'show'])
->middleware(['auth']);

// CRUD lowongan (khusus admin)
Route::resource('jobs',JobController::class)
->except(['index', 'show'])
->middleware(['auth', 'isAdmin']);

// Kirim lamaran pekerjaan (jobseeker)
Route::post('/jobs/{job}/apply',
[ApplicationController::class,
'store'])->name('apply.store')->middleware('auth');

// Daftar pelamar (hanya admin)
Route::get('/applicants',
[ApplicationController::class,
'index'])->name('applications.index')->middleware('isAdmin');

// Export data pelamar ke Excel (admin)
Route::get('/applications/export',[ApplicationController::class, 'export'])
->name('applications.export')
->middleware('isAdmin');

// CRUD lamaran (admin)
Route::resource('applications',ApplicationController::class)
->except(['index', 'show'])
->middleware(['auth', 'isAdmin']);

// Lihat detail lamaran (jobseeker/user biasa)
Route::resource('applications',ApplicationController::class)
->only(['index', 'show'])
->middleware(['auth']);

require __DIR__.'/auth.php';