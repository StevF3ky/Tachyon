<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tachyon | Library Saya</title>
    <link rel="stylesheet" href="{{ asset('css/library.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        .custom-dropdown { position: relative; margin-left: auto; }
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
        
        <div class="forum-header">
            <div>
                <h1>Library Saya</h1>
                <p>Kumpulan topik diskusi yang Anda simpan.</p>
            </div>
            
        </div>


        <div class="thread-list">
            
            @if(session('success'))
                <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($savedThreads as $thread)
                <div class="card">
                    
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        
                        <div class="thread-meta" style="margin-bottom: 0;">
                            <div class="author-avatar" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                {{ strtoupper(substr($thread->user->name, 0, 2)) }}
                            </div>
                            <div style="display: flex; flex-direction: column;">
                                <span class="author-name">{{ $thread->user->name }}</span>
                                <span class="post-time">{{ $thread->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <details class="custom-dropdown">
                            <summary>
                                <ion-icon name="ellipsis-horizontal" style="font-size: 20px; color: var(--text-muted); cursor: pointer;"></ion-icon>
                            </summary>
                            
                            <div class="dropdown-menu">
                                <form action="{{ route('library.toggle', $thread->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <ion-icon name="bookmark" style="font-size: 16px; color: #06b6d4;"></ion-icon> 
                                        Hapus dari Library
                                    </button>
                                </form>
                                
                                <button class="dropdown-item" style="color: #ef4444;">
                                    <ion-icon name="flag-outline" style="font-size: 16px;"></ion-icon> Report
                                </button>
                            </div>
                        </details>
                        </div>
                    
                    <h3 class="thread-title">{{ $thread->title }}</h3>
                    <p class="thread-excerpt">
                        {{ Str::limit($thread->content, 200) }}
                    </p>

                    @if($thread->image)
                        <div style="margin-top: 10px;">
                            <img src="{{ asset('storage/' . $thread->image) }}" style="max-height: 200px; border-radius: 8px;">
                        </div>
                    @endif

                    <div class="thread-footer">
                        <div class="tags-group">
                            <span class="tag-pill">#{{ ucfirst($thread->category_id) }}</span>
                        </div>
                        <div class="stats-group">
                            <div class="stat-item"><ion-icon name="chatbox-outline"></ion-icon> 0 Replies</div>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: var(--text-muted); padding: 40px;">
                    <p>Anda belum menyimpan topik atau thread apapun ke Library.</p>
                    <a href="{{ route('forum') }}" style="color: var(--accent-cyan); text-decoration: none; font-weight: 500; margin-top: 10px; display: inline-block;">
                        Jelajahi Forum atau Thread untuk menyimpan thread atau topik tersebut.
                    </a>
                </div>
            @endforelse

        </div>
    </div>

</body>
</html>