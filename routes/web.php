<?php
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\LibraryController; // Pastikan ini di-import
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Route Home menggunakan Controller untuk menampilkan data thread
Route::get('/', [ThreadController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// [UBAH DISINI] Route Library sekarang menggunakan Controller
// Agar bisa menampilkan daftar thread yang disimpan user
Route::get('/library', [LibraryController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('library');

// Route Forum Utama
Route::get('/forum', [ThreadController::class, 'forumIndex'])->name('forum');

Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])
    ->name('threads.comments.store');

Route::get('/article/{thread}', [ThreadController::class, 'showArticle'])->name('article.show');

// GROUP ROUTE YANG MEMBUTUHKAN LOGIN
Route::middleware('auth')->group(function () {

    // --- FITUR SAVE TO LIBRARY (BARU) ---
    // Route untuk proses Simpan / Hapus dari Library
    Route::post('/library/toggle/{thread}', [LibraryController::class, 'toggle'])->name('library.toggle');

    // --- IMPLEMENTASI OPSI B (DUA HALAMAN) ---

    // 1. Route untuk Artikel Panjang
    Route::get('/forum/create-article', function () {
        return view('create-thread'); 
    })->name('forum.create.article');

    // 2. Route untuk Topik Diskusi Cepat
    Route::get('/forum/create-topic', function () {
        return view('create-topic'); 
    })->name('forum.create.topic');

    // 3. Route Penyimpanan (Shared)
    Route::post('/forum/store', [ThreadController::class, 'store'])->name('forum.store');

    Route::get('/thread/{thread}', [ThreadController::class, 'show'])->name('thread.show');

    // -----------------------------------------

    // Route Profil
    Route::get('/my-profile', function () {
        return view('profile.show');
    })->name('profile.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';