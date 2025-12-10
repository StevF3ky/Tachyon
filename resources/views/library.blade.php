<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tachyon | Library</title>
    <link rel="stylesheet" href="{{ asset('css/library.css') }}">
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
                <ion-icon name="grid-outline"></ion-icon> <span>Feed</span>
            </a>
            <a href="{{ route('forum') }}" class="nav-item">
                <ion-icon name="globe-outline"></ion-icon> Forum
            </a>
            <a href="{{ route('library') }}" class="nav-item active">
                <ion-icon name="library-outline"></ion-icon> Library Saya
            </a>
        </div>

        <div class="sidebar-footer" style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
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
        </div>
    </nav>

    <div class="main-content">
        
        <div class="library-header">
            <div>
                <h1>Library Saya</h1>
                <p>Koleksi thread dan forum yang Anda simpan.</p>
            </div>
            <div class="library-stats">
                <span>3 Post Disimpan</span>
            </div>
        </div>

        <div class="saved-list">

            <div class="card">
                <div class="library-meta">
                    <ion-icon name="document-text-outline" class="source-icon"></ion-icon>
                    <span class="source-name">Posted by CyberSentinel</span>
                    <span class="saved-time">• Disimpan 2 jam yang lalu</span>
                </div>
                
                <h3 class="article-title">Analisis Malware 'DarkGate' Terbaru</h3>
                <p class="article-excerpt">
                    Laporan teknis mengenai penyebaran malware via phishing email yang menargetkan sektor finansial, 
                    lengkap dengan IoC (Indicators of Compromise).
                </p>

                <div class="library-actions">
                    <button class="btn-remove">
                        <ion-icon name="trash-outline"></ion-icon> Hapus dari Library
                    </button>
                    <a href="#" class="btn-read">
                        Baca Sekarang <ion-icon name="arrow-forward-outline"></ion-icon>
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="library-meta">
                    <ion-icon name="chatbubbles-outline" class="source-icon"></ion-icon>
                    <span class="source-name">Forum Diskusi • NetSec</span>
                    <span class="saved-time">• Disimpan 1 hari yang lalu</span>
                </div>
                
                <h3 class="article-title">Diskusi: Cara mengamankan server Ubuntu dari Brute Force</h3>
                <p class="article-excerpt">
                    Kumpulan tips dari komunitas mengenai konfigurasi Fail2Ban, penggunaan SSH Key, dan setting firewall 
                    untuk mencegah serangan brute force.
                </p>

                <div class="library-actions">
                    <button class="btn-remove">
                        <ion-icon name="trash-outline"></ion-icon> Hapus dari Library
                    </button>
                    <a href="#" class="btn-read">
                        Lihat Diskusi <ion-icon name="arrow-forward-outline"></ion-icon>
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="library-meta">
                    <ion-icon name="document-text-outline" class="source-icon"></ion-icon>
                    <span class="source-name">Article by Alice Inchains</span>
                    <span class="saved-time">• Disimpan 1 minggu yang lalu</span>
                </div>
                
                <h3 class="article-title">Tutorial: SQL Injection Manual pada PHP</h3>
                <p class="article-excerpt">
                    Panduan langkah demi langkah melakukan eksploitasi SQL Injection secara manual tanpa tools otomatis, 
                    bertujuan untuk memahami cara kerja vulnerability ini secara mendalam.
                </p>

                <div class="library-actions">
                    <button class="btn-remove">
                        <ion-icon name="trash-outline"></ion-icon> Hapus dari Library
                    </button>
                    <a href="#" class="btn-read">
                        Baca Sekarang <ion-icon name="arrow-forward-outline"></ion-icon>
                    </a>
                </div>
            </div>

        </div>
    </div>

</body>
</html>