<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tachyon | Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    
    <style>
        .custom-dropdown { position: relative; }
        .custom-dropdown summary { list-style: none; cursor: pointer; }
        .custom-dropdown summary::-webkit-details-marker { display: none; }
        
        .dropdown-menu {
            position: absolute; right: 0; top: 100%; width: 180px;
            background: #0f172a; border: 1px solid #1e293b; border-radius: 12px;
            padding: 8px; z-index: 50; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
            display: flex; flex-direction: column; gap: 4px;
        }
        
        .dropdown-item {
            width: 100%; text-align: left; background: none; border: none;
            color: #94a3b8; padding: 8px 12px; font-size: 13px;
            cursor: pointer; border-radius: 6px; display: flex; align-items: center; gap: 8px;
            text-decoration: none; transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .dropdown-item:hover { background: rgba(255, 255, 255, 0.05); color: white; }
    </style>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>

    <input type="checkbox" id="sidebar-toggle" class="logic-control">
    <label for="sidebar-toggle" class="overlay" style="display: none;"></label>

    <nav class="sidebar">
        <div class="logo-area">
            <div class="logo-box"><ion-icon name="layers-outline"></ion-icon></div>
            <span class="brand-text">TACHYON</span>
        </div>

        <div class="nav-menu">
            <a href="{{ route('home') }}" class="nav-item active">
                <ion-icon name="grid-outline"></ion-icon> Feed
            </a>
            <a href="{{ route('forum') }}" class="nav-item">
                <ion-icon name="globe-outline"></ion-icon> Forum
            </a>
            @auth
            <a href="{{ route('library') }}" class="nav-item">
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

    <main class="main-content">
        <header>
            <div class="search-bar">
                <input type="text" placeholder="Cari thread, malware, atau user...">
            </div>
            
            <div class="header-actions">
                @auth
                    <a href="{{ route('forum.create.article') }}" class="btn-write" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        <ion-icon name="create-outline" style="font-size: 18px;"></ion-icon>
                        <span style="display: none; @media(min-width: 640px){display:inline;}">Tulis Artikel</span>
                    </a>
                @else
                    <span style="color: #64748b; font-size: 14px;">Mode Tamu</span>
                @endauth
            </div>
        </header>

        <div class="feed-container">
            <div class="content-section">
                
                @if(session('success'))
                    <div style="background: rgba(6, 182, 212, 0.2); color: #06b6d4; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #06b6d4;">
                        {{ session('success') }}
                    </div>
                @endif

                @foreach($threads as $thread)
                    <div class="post-card">
                        <article>
                            <div class="card-header">
                                    <div class="thread-meta" style="margin-bottom: 0;">
                                        <div class="author-avatar" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                            {{ strtoupper(substr($thread->user->name, 0, 2)) }}
                                        </div>
                                        <div style="display: flex; flex-direction: column;">
                                            <span class="author-name">{{ $thread->user->name }}</span>
                                            <span class="post-time">{{ $thread->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                
                                <div class="post-options">
                                    <details class="custom-dropdown">
                                        <summary>
                                            <ion-icon name="ellipsis-horizontal" style="font-size: 20px; color: var(--text-muted); cursor: pointer;"></ion-icon>
                                        </summary>
                                        
                                        <div class="dropdown-menu">
                                            @auth
                                                @php
                                                    // Cek manual ke DB (Sesuai Cara Alternatif)
                                                    $isSaved = \Illuminate\Support\Facades\DB::table('saved_threads')
                                                        ->where('user_id', Auth::id())
                                                        ->where('thread_id', $thread->id)
                                                        ->exists();
                                                @endphp

                                                <form action="{{ route('library.toggle', $thread->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <ion-icon name="{{ $isSaved ? 'bookmark' : 'bookmark-outline' }}" 
                                                                  style="font-size: 16px; color: {{ $isSaved ? '#06b6d4' : 'inherit' }};">
                                                        </ion-icon> 
                                                        {{ $isSaved ? 'Tersimpan' : 'Simpan ke Library' }}
                                                    </button>
                                                </form>
                                                
                                                <button class="dropdown-item" style="color: #ef4444;">
                                                    <ion-icon name="flag-outline" style="font-size: 16px;"></ion-icon> Report
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}" class="dropdown-item">
                                                    <ion-icon name="log-in-outline" style="font-size: 16px;"></ion-icon> Login untuk Simpan
                                                </a>
                                            @endauth
                                        </div>
                                    </details>
                                </div>

                            </div>

                            <div class="card-body">
                                <a href="{{ route('thread.show', $thread->id) }}" style="text-decoration: none; color: inherit;">
                                    <h3 class="card-title">{{ $thread->title }}</h3>
                                </a>
                                <p class="card-excerpt">
                                    {{ Str::limit($thread->content, 150) }}
                                </p>

                                @if($thread->image)
                                 <div style="margin-top: 15px; border-radius: 8px; overflow: hidden; max-height: 300px; display: flex; justify-content: center; align-items: center;"> 
                                    <img src="{{ asset('storage/' . $thread->image) }}" 
                                        alt="Thread Image" 
                                        style="max-width: 100%; /* Pastikan lebar tidak melebihi card */
                                                max-height: 300px; /* Batasi tinggi maksimum */
                                                width: auto; 
                                                height: auto; /* Biarkan tinggi menyesuaikan rasio asli */
                                                margin-bottom: 25px;
                                                object-fit: contain; /* PENTING: Mencegah gambar terpotong */">
                                </div>
                                @endif
                            </div>
                            
                            <div class="card-actions">
                                <div style="display: flex; gap: 20px;">
                                    <button class="action-btn"><ion-icon name="heart-outline"></ion-icon> 0</button>
                                    <button class="action-btn"><ion-icon name="chatbubble-outline"></ion-icon> 0</button>
                                </div>
                                <span class="tag-pill">{{ ucfirst($thread->category_id) }}</span>
                            </div>
                        </article>
                    </div>
                @endforeach

                @if($threads->isEmpty())
                    <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                        <ion-icon name="file-tray-outline" style="font-size: 48px; margin-bottom: 10px;"></ion-icon>
                        <p>Belum ada artikel. Jadilah yang pertama!</p>
                    </div>
                @endif

                

            </div>
        </div>
    </main>

</body>
</html>