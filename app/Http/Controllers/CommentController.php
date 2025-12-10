<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Pastikan hanya user yang login yang bisa memberi komentar
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function store(Request $request, $threadId)
    {
        $request->validate([
            'content' => 'required|min:3',
        ]);

        // Buat komentar
        Comment::create([
            'thread_id' => $threadId,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        // Redirect kembali ke halaman detail Thread/Topik.
        // Anda perlu menentukan rute mana yang harus dikunjungi.
        // Asumsi: Kita kembali ke URL sebelumnya
        return back()->with('success', 'Balasan berhasil ditambahkan!');
    }
}