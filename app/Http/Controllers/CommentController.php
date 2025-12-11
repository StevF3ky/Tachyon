<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $threadId)
    {
        $request->validate([
            'content' => 'required',
            'parent_id' => 'nullable|exists:comments,id' // Validasi parent_id
        ]);

        Comment::create([
            'thread_id' => $threadId,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id ?? null, // Simpan ID komentar induk jika ada
        ]);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }
}