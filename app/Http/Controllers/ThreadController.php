<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ThreadController extends Controller
{
    // 1. HOME PAGE (Hanya menampilkan Artikel)
    public function index()
    {
        // Filter: Ambil yang type-nya 'article'
        $threads = Thread::with('user')
                    ->where('type', 'article') 
                    ->latest()
                    ->get();

        return view('welcome', compact('threads'));
    }

    // 2. FORUM PAGE (Hanya menampilkan Topik Diskusi)
    public function forumIndex()
    {
        // Filter: Ambil yang type-nya 'topic'
        $threads = Thread::with('user')
                    ->where('type', 'topic')
                    ->latest()
                    ->get();

        return view('forum', compact('threads'));
    }

        public function show(Thread $thread)
    {
        // Objek $thread sudah diisi oleh Laravel (Route Model Binding)
        // Kita bisa tambahkan eager loading jika ada relasi lain
        
        // Kirim objek $thread ke view detail
        return view('thread', compact('thread'));
    }
    // 3. MENYIMPAN DATA (Bisa Artikel atau Topik)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required',
            'content' => 'required',
            'type' => 'required', // Wajib dikirim dari form (hidden input)
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('threads', 'public');
        }

        // Simpan ke Database
        Thread::create([
            'user_id' => Auth::id(),
            'type' => $request->type, // 'article' atau 'topic'
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        // Redirect sesuai tipe
        if ($request->type == 'topic') {
            return redirect()->route('forum')->with('success', 'Topik diskusi berhasil dibuat!');
        }
        
        

        return redirect()->route('home')->with('success', 'Artikel berhasil diterbitkan!');
    }

    // --- TAMBAHAN BARU ---

    // 4. MENGHAPUS POST (Delete)
    public function destroy(Thread $thread)
    {
        // Pastikan hanya pemilik thread yang bisa menghapus
        if (Auth::id() !== $thread->user_id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus postingan ini.');
        }

        // Hapus gambar jika ada
        if ($thread->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($thread->image);
        }

        $thread->delete();

        // Redirect ke halaman yang sesuai
        if ($thread->type == 'article') {
            return redirect()->route('home')->with('success', 'Artikel berhasil dihapus.');
        } else {
            return redirect()->route('forum')->with('success', 'Topik diskusi berhasil dihapus.');
        }
    }

    // 5. LIKE / UNLIKE (Toggle)
    public function toggleLike(Thread $thread)
    {
        // Fitur ini otomatis: Kalau belum like -> jadi like. Kalau sudah like -> jadi unlike.
        $thread->likes()->toggle(Auth::id());

        return back();
    }
}