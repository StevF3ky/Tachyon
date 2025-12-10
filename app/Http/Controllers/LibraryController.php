<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Thread; // Pastikan Anda memiliki model Thread

class LibraryController extends Controller
{
    /**
     * Menampilkan daftar thread yang disimpan oleh user yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil ID thread yang disimpan oleh user ini dari tabel pivot
        $savedThreadIds = DB::table('saved_threads')
            ->where('user_id', $user->id)
            ->pluck('thread_id');
        
        // 2. Ambil objek Thread lengkap berdasarkan ID yang didapat
        $savedThreads = Thread::whereIn('id', $savedThreadIds)
            ->with('user') // Agar bisa menampilkan nama user pembuat thread
            ->latest()
            ->get();

        return view('library', compact('savedThreads'));
    }

    /**
     * Menambah atau menghapus thread dari Library (toggle).
     */
    public function toggle(Thread $thread)
    {
        $user = Auth::user();

        // Cek apakah thread sudah disimpan
        $isSaved = DB::table('saved_threads')
            ->where('user_id', $user->id)
            ->where('thread_id', $thread->id);

        if ($isSaved->exists()) {
            // Jika sudah ada, hapus (unsave)
            $isSaved->delete();
            $message = 'Topik berhasil dihapus dari Library.';
        } else {
            // Jika belum ada, simpan
            DB::table('saved_threads')->insert([
                'user_id' => $user->id,
                'thread_id' => $thread->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $message = 'Topik berhasil disimpan ke Library.';
        }

        return back()->with('success', $message);
    }
}