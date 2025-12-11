<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tachyon | {{ $thread->title }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/thread.css') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <style>
        .comment-form { margin-top: 20px; margin-bottom: 30px; }
        .comment-input {
            width: 100%; background: #0f172a; border: 1px solid #334155;
            padding: 15px; color: white; border-radius: 8px; margin-bottom: 10px;
            font-family: 'Inter', sans-serif; resize: vertical;
        }
        .btn-submit-comment {
            background: #06b6d4; color: white; border: none; padding: 10px 20px;
            border-radius: 6px; cursor: pointer; font-weight: 600;
        }
        .single-comment {
            border-bottom: 1px solid rgba(255,255,255,0.1); padding: 20px 0;
        }
        .comment-meta { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .comment-author { color: #06b6d4; font-weight: 600; font-size: 14px; }
        .comment-date { color: #64748b; font-size: 12px; }
        .comment-text { color: #cbd5e1; line-height: 1.6; font-size: 14px; }

        /* --- CSS UNTUK KOMENTAR BERSARANG (NESTED) --- */
        
        /* Ini yang bikin komentar menjorok ke dalam (Reply) */
        .nested-comment {
            margin-left: 40px;          /* Geser ke kanan 40px */
            border-left: 2px solid #334155; /* Garis tiang di kiri */
            padding-left: 15px;         /* Jarak teks dari garis */
            margin-top: 15px;
            display: block;             /* Pastikan blok baru */
        }

        /* Tombol Vote Kecil di Komentar */
        .btn-vote-sm {
            background: none; 
            border: none; 
            cursor: pointer; 
            display: flex; 
            align-items: center; 
            gap: 4px; 
            font-size: 12px; 
            font-weight: 600;
            padding: 4px;
            border-radius: 4px;
            transition: background 0.2s;
        }
        .btn-vote-sm:hover {
            background: rgba(255,255,255,0.05);
        }

        /* Form Reply Input */
        .comment-input {
            width: 100%;
            background: #0f172a;
            border: 1px solid #334155;
            color: white;
            padding: 10px;
            border-radius: 6px;
            font-family: inherit;
        }
        .btn-submit-comment {
            background: #06b6d4;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
        }

        /* Perbaikan responsif untuk HP */
        @media (max-width: 600px) {
            .nested-comment {
                margin-left: 15px; /* Kalau di HP gesernya dikit aja biar gak sempit */
            }
        }
    </style>

    <script>
        function toggleReplyForm(commentId) {
            var form = document.getElementById('reply-form-' + commentId);
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</head>
<body>

 <nav class="sidebar">
        <div class="logo-area">
            <div class="logo-box"><ion-icon name="layers-outline"></ion-icon></div>
            <span class="brand-text">TACHYON</span>
        </div>

        <div class="nav-menu">
            <a href="{{ route('home') }}" class="nav-item">
                <ion-icon name="grid-outline"></ion-icon> Feed
            </a>

            <a href="{{ route('forum') }}" class="nav-item">
                <ion-icon name="globe-outline"></ion-icon> Forum
            </a>
            
            @auth
            <a href="{{ route('library') }}" class="nav-item active">
                <ion-icon name="library-outline"></ion-icon> Library Saya
            </a>
            @endauth
        </div>

        <div class="sidebar-footer" style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
            @auth
                <div class="user-profile">
                    <div class="avatar" style="width: 35px; height: 35px; background: #06b6d4; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div style="flex: 1; overflow: hidden; margin-left: 10px;">
                        <a href="{{ route('profile.show') }}" style="color: white; font-weight: 600; text-decoration: none;">
                            {{ Auth::user()->name }}
                        </a>
                        <p style="color: var(--text-muted); font-size: 12px;">{{ Auth::user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer; color: var(--text-muted); font-size: 20px;">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="auth-buttons" style="display: flex; flex-direction: column; gap: 10px;">
                    <a href="{{ route('login') }}" style="text-decoration: none; text-align: center; padding: 10px; background: transparent; border: 1px solid #06b6d4; color: #06b6d4; border-radius: 8px;">Masuk</a>
                    <a href="{{ route('register') }}" style="text-decoration: none; text-align: center; padding: 10px; background: #06b6d4; color: white; border-radius: 8px;">Daftar</a>
                </div>
            @endguest
        </div>
    </nav>

    <div class="main-content">
        <header>
            </header>

        <div class="thread-container">
            <a href="{{ $thread->type == 'topic' ? route('forum') : route('home') }}" class="btn-back">
    <ion-icon name="arrow-back-outline"></ion-icon> 
    Kembali ke {{ $thread->type == 'topic' ? 'Forum' : 'Feed' }}
</a>

            @if(session('success'))
                <div style="background: rgba(6, 182, 212, 0.2); color: #06b6d4; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #06b6d4;">
                    {{ session('success') }}
                </div>
            @endif

            <article class="thread-main-card">
                <div class="thread-header">
                    <div class="thread-author-meta">
                        <div class="thread-avatar">{{ strtoupper(substr($thread->user->name, 0, 2)) }}</div>
                        <div class="author-details">
                            <h4>{{ $thread->user->name }}
                                <span style="color: var(--accent-cyan); font-weight:400; font-size: 12px; margin-left: 4px;">
                                    {{ $thread->type == 'article' ? 'Artikel' : 'Topik Diskusi' }}
                                </span>
                            </h4>
                            <span>Posted {{ $thread->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    <details class="custom-dropdown">
                        <summary class="thread-menu-btn"><ion-icon name="ellipsis-horizontal"></ion-icon></summary>
                        <div class="dropdown-menu">
                            @auth
                                @php
                                    $isSaved = \Illuminate\Support\Facades\DB::table('saved_threads')
                                            ->where('user_id', Auth::id())
                                            ->where('thread_id', $thread->id)
                                            ->exists();
                                @endphp
                                <form action="{{ route('library.toggle', $thread->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <ion-icon name="{{ $isSaved ? 'bookmark' : 'bookmark-outline' }}" style="font-size: 16px;"></ion-icon> 
                                        {{ $isSaved ? 'Tersimpan' : 'Simpan' }}
                                    </button>
                                </form>
                                {{-- TAMBAHAN: Tombol Delete (Hanya muncul jika user adalah pemilik thread) --}}
                                @if(Auth::id() === $thread->user_id)
                                    <form action="{{ route('thread.destroy', $thread->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item" style="color: #ef4444;">
                                            <ion-icon name="trash-outline" style="font-size: 16px;"></ion-icon> Hapus Postingan
                                        </button>
                                    </form>
                                @endif
                                <button class="dropdown-item" style="color: #ef4444;">
                                    <ion-icon name="flag-outline" style="font-size: 16px;"></ion-icon> Report
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="dropdown-item"><ion-icon name="log-in-outline"></ion-icon> Login</a>
                            @endauth
                        </div>
                    </details>
                </div>

                <div class="thread-content">
                    <h1>{{ $thread->title }}</h1>
                    
                    <div class="thread-body">
                        @if($thread->image)
                            <div class="thread-image" style="margin-bottom: 20px;">
                                <img src="{{ asset('storage/' . $thread->image) }}" alt="Cover Image" style="max-width: 100%; height: auto; border-radius: 8px;">
                            </div>
                        @endif
                        
                        <p>{!! nl2br(e($thread->content)) !!}</p>
                    </div>

                    <div class="thread-tags">
                        <span class="thread-tag">#{{ ucfirst($thread->category_id) }}</span>
                    </div>
                </div>

                <div class="interaction-bar">
    <div class="interaction-left">
        
        <form action="{{ route('vote') }}" method="POST" style="display:inline;">
            @csrf
            <input type="hidden" name="votable_id" value="{{ $thread->id }}">
            <input type="hidden" name="votable_type" value="thread">
            
            {{-- Logic Tampilan: Kalau Artikel pakai LOVE, Kalau Forum pakai UPVOTE --}}
            @if($thread->type == 'article')
                <input type="hidden" name="value" value="1">
                @php
                    $isLiked = Auth::check() && $thread->votes->where('user_id', Auth::id())->where('value', 1)->isNotEmpty();
                @endphp
                <button class="interact-btn" style="{{ $isLiked ? 'color: #f43f5e;' : '' }}">
                    <ion-icon name="{{ $isLiked ? 'heart' : 'heart-outline' }}"></ion-icon> 
                    {{ $thread->score }} Like
                </button>
            @else
                {{-- Kalau Topik Forum, Tampilkan Upvote Sederhana --}}
                <input type="hidden" name="value" value="1">
                 @php
                    $isUpvoted = Auth::check() && $thread->votes->where('user_id', Auth::id())->where('value', 1)->isNotEmpty();
                @endphp
                <button class="interact-btn" style="{{ $isUpvoted ? 'color: #f97316;' : '' }}">
                    <ion-icon name="caret-up-outline"></ion-icon> 
                    {{ $thread->score }} Upvote
                </button>
            @endif
        </form>

        <button class="interact-btn">
            <ion-icon name="chatbubble-outline"></ion-icon> {{ $thread->comments->count() }} Comment
        </button>
    </div>
</div>
            </article>

            <div class="comments-section">
                <h3 class="comments-header">Diskusi ({{ $thread->comments->count() }})</h3>
                
                @auth
                    <form action="{{ route('comment.store', $thread->id) }}" method="POST" class="comment-form">
                        @csrf
                        <textarea name="content" rows="3" class="comment-input" placeholder="Tulis pendapatmu..."></textarea>
                        <button type="submit" class="btn-submit-comment">Kirim Komentar</button>
                    </form>
                @else
                    <div class="guest-comment-area" style="margin-bottom: 20px;">
                        <a href="{{ route('login') }}" class="btn-guest-login" style="color:#06b6d4; text-decoration:underline;">Login untuk membalas</a>
                    </div>
                @endauth

                <div class="comment-list">
    
    @include('partials.comment-item', [
        'comments' => $thread->comments->where('parent_id', null)
    ])

    @if($thread->comments->count() == 0)
        <p style="color: #64748b; font-style: italic; margin-top: 20px;">Belum ada komentar. Jadilah yang pertama!</p>
    @endif

</div>

            </div>
        </div>
    </div>

</body>
</html>