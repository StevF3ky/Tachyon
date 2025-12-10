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
            <a href="{{ route('home') }}" class="btn-back">
                <ion-icon name="arrow-back-outline"></ion-icon> Kembali ke Feed
            </a>

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
                                    <button class="dropdown-item" style="color: #ef4444;">
                                                    <ion-icon name="flag-outline" style="font-size: 16px;"></ion-icon> Report
                                    </button>
                                </form>
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
                        
                        <p>{{ nl2br(e($thread->content)) }}</p>

                    </div>

                    <div class="thread-tags">
                        <span class="thread-tag">#{{ ucfirst($thread->category_id) }}</span>
                        @if($thread->tags)
                            @foreach(explode(',', $thread->tags) as $tag)
                                <span class="thread-tag">#{{ trim($tag) }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="interaction-bar">
                    <div class="interaction-left">
                        <button class="interact-btn"><ion-icon name="heart-outline"></ion-icon> Like</button>
                        <button class="interact-btn"><ion-icon name="chatbubble-outline"></ion-icon> Comment</button>
                    </div>
                </div>
            </article>

            <div class="comments-section">
                <h3 class="comments-header">Diskusi</h3>
                                 
                @guest
                    <div class="guest-comment-area">
                        <a href="{{ route('login') }}" class="btn-guest-login">Login untuk membalas</a>
                    </div>
                @endguest

            </div>
        </div>
    </div>

</body>
</html>