<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // Kita akan pakai welcome.blade.php sebagai file utama
})->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk Library (Hanya bisa diakses jika Login)
Route::get('/library', function () {
    return view('library');
})->middleware(['auth', 'verified'])->name('library');

Route::get('/forum', function () {
    return view('forum');
})->name('forum');

Route::middleware('auth')->group(function () {
    // Route untuk MELIHAT profil (Halaman dengan tombol Edit)
    Route::get('/my-profile', function () {
        return view('profile.show');
    })->name('profile.show');

    // Route bawaan Breeze untuk EDIT profil (tetap seperti semula)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
