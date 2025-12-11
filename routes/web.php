<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LibraryController;

/*
|--------------------------------------------------------------------------
| Web Routes (Tachyon)
|--------------------------------------------------------------------------
*/

// --- 1. ROUTE PUBLIK (Bisa diakses tanpa login) ---

// Homepage (Feed)
Route::get('/', [ThreadController::class, 'index'])->name('home');

// Halaman Forum
Route::get('/forum', [ThreadController::class, 'forumIndex'])->name('forum');

// Halaman Baca Artikel/Thread (Detail)
Route::get('/thread/{thread}', [ThreadController::class, 'show'])->name('thread.show');


// --- 2. ROUTE AUTH (Harus Login) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (Redirect ke home saja)
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    // --- FITUR THREAD (Create, Delete, Like) ---
    // Simpan Thread Baru
    Route::post('/thread', [ThreadController::class, 'store'])->name('thread.store'); 
    
    // Hapus Thread (Ini solusi agar tombol Delete berfungsi)
    Route::delete('/thread/{thread}', [ThreadController::class, 'destroy'])->name('thread.destroy'); 
    
    // Like Thread (Ini solusi error 'thread.like not defined')
    Route::post('/vote', [App\Http\Controllers\VoteController::class, 'vote'])->name('vote');

    // --- FITUR KOMENTAR ---
    Route::post('/thread/{id}/comment', [CommentController::class, 'store'])->name('comment.store');

    // --- FITUR LIBRARY ---
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::post('/library/toggle/{thread}', [LibraryController::class, 'toggle'])->name('library.toggle');

    // --- HALAMAN PEMBUATAN KONTEN (View Only) ---
    // Pastikan nama file view-nya sesuai dengan yang ada di folder resources/views
    Route::get('/create-article', function() { 
        return view('create-thread'); // Sesuaikan nama file blade kamu
    })->name('forum.create.article');

    Route::get('/create-topic', function() { 
        return view('create-topic'); // Sesuaikan nama file blade kamu
    })->name('forum.create.topic');

    // --- PROFILE USER ---
    Route::get('/my-profile', function () { return view('profile.show'); })->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';