<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tachyon | Forum Diskusi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <style>
        /* CSS Tambahan Khusus Layout Forum (Reddit Style) */
        
        /* Dropdown Menu (Copied from Feed for consistency) */
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

        /* --- Layout Grid 2 Kolom --- */
        .forum-grid {
            display: grid;
            grid-template-columns: 1fr 300px; /* Kiri Lebar, Kanan 300px */
            gap: 24px;
            margin-top: 20px;
        }

        /* Card Style Modifikasi untuk Forum */
        .reddit-card {
            background: #1e293b; /* Samakan dengan warna card feed */
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 12px;
            display: flex;
            overflow: hidden;
            margin-bottom: 15px;
            transition: transform 0.2s;
        }
        .reddit-card:hover { transform: translateY(-2px); border-color: #334155; }

        /* Vote Bar (Kiri) */
        .vote-section {
            width: 45px;
            background: rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 15px;
            gap: 2px;
            border-right: 1px solid rgba(255,255,255,0.05);
        }
        .vote-btn { color: #64748b; cursor: pointer; font-size: 20px; padding: 2px; }
        .vote-btn:hover { color: #06b6d4; background: rgba(255,255,255,0.05); border-radius: 4px; }
        .vote-count { font-size: 13px; font-weight: 700; color: #f1f5f9; margin: 5px 0; }

        /* Content (Kanan) */
        .content-section { flex: 1; padding: 16px; }
        .meta-header { font-size: 12px; color: #94a3b8; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
        .subreddit-name { font-weight: 700; color: #f1f5f9; }
        .user-link { color: #94a3b8; text-decoration: none; }
        .user-link:hover { color: #06b6d4; }

        .post-title { font-size: 1.1rem; font-weight: 600; color: white; text-decoration: none; display: block; margin-bottom: 8px; line-height: 1.4; }
        .post-preview { font-size: 0.95rem; color: #cbd5e1; margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6; }

        .action-bar { display: flex; gap: 15px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 10px; margin-top: 10px; }
        .action-pill { background: none; border: none; color: #94a3b8; display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; cursor: pointer; padding: 6px 8px; border-radius: 6px; transition: 0.2s; }
        .action-pill:hover { background: rgba(255,255,255,0.05); color: white; }

        /* Sidebar Kanan (Info) */
        .right-sidebar { display: flex; flex-direction: column; gap: 20px; }
        .info-card { background: #1e293b; border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; overflow: hidden; }
        .info-header { background: linear-gradient(135deg, #06b6d4, #3b82f6); padding: 15px; color: white; font-weight: 700; font-size: 14px; }
        .info-body { padding: 15px; font-size: 13px; color: #cbd5e1; line-height: 1.6; }
        .rule-item { border-bottom: 1px solid rgba(255,255,255,0.1); padding: 8px 0; }
        .rule-item:last-child { border-bottom: none; }
        
        .btn-join-community { display: block; width: 100%; padding: 10px; background: white; color: #0f172a; text-align: center; border-radius: 20px; font-weight: 700; text-decoration: none; margin-top: 15px; transition: 0.2s; }
        .btn-join-community:hover { background: #cbd5e1; }

        /* Responsive */
        @media (max-width: 900px) {
            .forum-grid { grid-template-columns: 1fr; } /* Jadi 1 kolom di HP */
            .right-sidebar { display: none; } /* Hide sidebar info di HP */
        }
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
            <a href="{{ route('home') }}" class="nav-item">
                <ion-icon name="grid-outline"></ion-icon> Feed
            </a>
            <a href="{{ route('forum') }}" class="nav-item active"> <ion-icon name="globe-outline"></ion-icon> Forum
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
                <input type="text" placeholder="Cari topik diskusi...">
            </div>
            
            <div class="header-actions">
                @auth
                    <a href="{{ route('forum.create.topic') }}" class="btn-write" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        <ion-icon name="add-circle-outline" style="font-size: 18px;"></ion-icon>
                        <span style="display: none; @media(min-width: 640px){display:inline;}">Buat Topik</span>
                    </a>
                @endauth
            </div>
        </header>

        <div class="feed-container"> @if(session('success'))
                <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <div style="margin-bottom: 20px;">
                <h1 style="font-size: 1.8rem; color: white; margin-bottom: 5px;">Forum Diskusi</h1>
                <p style="color: #94a3b8;">Komunitas terbuka untuk berdiskusi masalah teknis.</p>
            </div>

            <div class="forum-grid">
                
                <div class="feed-column">
                    @forelse($threads as $thread)
                        <div class="reddit-card">
                            <div class="vote-section">
                                @php
                                    // Cek apakah user sudah vote thread ini
                                    $userVote = Auth::check() ? $thread->votes->where('user_id', Auth::id())->first() : null;
                                    $voteValue = $userVote ? $userVote->value : 0;
                                @endphp

                                <form action="{{ route('vote') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="votable_id" value="{{ $thread->id }}">
                                    <input type="hidden" name="votable_type" value="thread">
                                    <input type="hidden" name="value" value="1">
                                    <button type="submit" style="background:none; border:none; padding:0;">
                                        <ion-icon name="caret-up-outline" 
                                            class="vote-btn" 
                                            style="color: {{ $voteValue == 1 ? '#f97316' : '#64748b' }}; font-weight: bold;">
                                        </ion-icon>
                                    </button>
                                </form>

                                <span class="vote-count" style="color: {{ $voteValue == 1 ? '#f97316' : ($voteValue == -1 ? '#3b82f6' : 'white') }}">
                                    {{ $thread->score }}
                                </span>

                                <form action="{{ route('vote') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="votable_id" value="{{ $thread->id }}">
                                    <input type="hidden" name="votable_type" value="thread">
                                    <input type="hidden" name="value" value="-1">
                                    <button type="submit" style="background:none; border:none; padding:0;">
                                        <ion-icon name="caret-down-outline" 
                                           class="vote-btn" 
                                            style="color: {{ $voteValue == -1 ? '#3b82f6' : '#64748b' }};">
                                        </ion-icon>
                                    </button>
                                </form>
                            </div>

                            <div class="content-section">
                               {{-- ... (Isi konten sama seperti sebelumnya, tidak berubah) ... --}}
                               {{-- Hanya pastikan di action-bar tombol Like dihapus karena sudah ada di kiri --}}
                               <div class="meta-header">
                                    {{-- ... meta ... --}}
                               </div>
                               <a href="{{ route('thread.show', $thread->id) }}" class="post-title">{{ $thread->title }}</a>
                               <div class="post-preview">{{ $thread->content }}</div>
                               <div class="action-bar">
                                    <a href="{{ route('thread.show', $thread->id) }}" class="action-pill" style="text-decoration: none;">
                                        <ion-icon name="chatbox-outline"></ion-icon> {{ $thread->comments->count() }} Comments
                                    </a>
                                    <button class="action-pill"><ion-icon name="share-social-outline"></ion-icon> Share</button>
                               </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 40px; color: #94a3b8; border: 1px dashed #334155; border-radius: 12px;">
                            <ion-icon name="chatbubbles-outline" style="font-size: 48px; margin-bottom: 10px;"></ion-icon>
                            <p>Belum ada topik diskusi. Jadilah yang pertama!</p>
                        </div>
                    @endforelse
                </div>

                <div class="right-sidebar">
                    <div class="info-card">
                        <div class="info-header">
                            Tentang Komunitas
                        </div>
                        <div class="info-body">
                            <p style="margin-bottom: 15px;">Tachyon Forum adalah tempat berdiskusi tentang exploit, defense, CTF, dan karir keamanan siber.</p>
                            
                            <div style="display: flex; gap: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
                                <div>
                                    <div style="font-weight: 700; font-size: 16px; color: white;">1.2k</div>
                                    <div style="font-size: 11px; color: #94a3b8;">Members</div>
                                </div>
                                <div>
                                    <div style="font-weight: 700; font-size: 16px; color: #10b981;">● 24</div>
                                    <div style="font-size: 11px; color: #94a3b8;">Online</div>
                                </div>
                            </div>
                            
                            @guest
                                <a href="{{ route('login') }}" class="btn-join-community">Gabung Komunitas</a>
                            @endguest
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-header" style="background: #334155;">
                            Peraturan Forum
                        </div>
                        <div class="info-body">
                            <div class="rule-item">1. Bersikap sopan & profesional.</div>
                            <div class="rule-item">2. Dilarang share malware aktif.</div>
                            <div class="rule-item">3. No illegal hacking request.</div>
                            <div class="rule-item">4. Gunakan flair yang sesuai.</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>