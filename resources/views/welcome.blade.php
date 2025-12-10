<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tachyon | Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    
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
                    <a href="{{ route('login') }}" style="text-decoration: none; text-align: center; padding: 10px; background: transparent; border: 1px solid #06b6d4; color: #06b6d4; border-radius: 8px;">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" style="text-decoration: none; text-align: center; padding: 10px; background: #06b6d4; color: white; border-radius: 8px;">
                        Daftar
                    </a>
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
                    <div class="header-actions">
                <button class="btn-write">
                    <ion-icon name="create-outline" style="font-size: 18px;"></ion-icon>
                    <span style="display: none; @media(min-width: 640px){display:inline;}">Tulis Artikel</span>
                </button>
                    </div>
                @else
                    <span style="color: #64748b; font-size: 14px;">Mode Tamu</span>
                @endauth
            </div>
        </header>

        <div class="feed-container">
            <div class="content-section">
                <div class="post-card">
                    <article>
                        <div class="card-header">
                            <div class="user-meta">
                                <div class="avatar-small"></div>
                                <div>
                                    <span class="user-name">CyberSentinel</span>
                                    <span class="post-time">2 jam yang lalu</span>
                                </div>
                            </div>
                            
                            <div class="post-options">
                                <details class="custom-dropdown">
                                    <summary>
                                        <ion-icon name="ellipsis-horizontal" style="font-size: 20px;"></ion-icon>
                                    </summary>
                                    
                                    <div class="dropdown-menu">
                                        @auth
                                            <button class="dropdown-item">
                                                <ion-icon name="bookmark-outline" style="font-size: 16px;"></ion-icon> Save to Library
                                            </button>
                                            <button class="dropdown-item text-red">
                                                <ion-icon name="flag-outline" style="font-size: 16px;"></ion-icon> Report
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}" class="dropdown-item">
                                                <ion-icon name="log-in-outline" style="font-size: 16px;"></ion-icon> Login to Interact
                                            </a>
                                        @endauth
                                    </div>
                                </details>
                            </div>
                        </div>

                        <div class="card-body">
                            <h3 class="card-title">Analisis Malware 'DarkGate' Terbaru</h3>
                            <p class="card-excerpt">Laporan teknis mengenai penyebaran malware via phishing email yang menargetkan sektor finansial...</p>
                        </div>
                        
                        <div class="card-actions">
                            <div style="display: flex; gap: 20px;">
                                <button class="action-btn"><ion-icon name="heart-outline"></ion-icon> 856</button>
                                <button class="action-btn"><ion-icon name="chatbubble-outline"></ion-icon> 23</button>
                            </div>
                            <span class="tag-pill">Malware</span>
                        </div>
                    </article>
                </div>
                </div>
        </div>
    </main>

</body>
</html>