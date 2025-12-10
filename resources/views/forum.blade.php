<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tachyon | Forum Diskusi</title>
    <link rel="stylesheet" href="{{ asset('css/forum.css') }}">
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

            <a href="{{ route('forum') }}" class="nav-item active">
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

    <div class="main-content">
        
        <div class="forum-header">
            <div>
                <h1>Forum Diskusi</h1>
                <p>Ruang diskusi publik seputar cyber security, exploit, dan defense.</p>
            </div>
            
            @auth
                <button class="btn-create-thread">
                    <ion-icon name="add-circle-outline" style="font-size: 20px;"></ion-icon>
                    Buat Topik Baru
                </button>

            @endauth
        </div>


        <div class="thread-list">

            <div class="card">
                <div class="thread-meta">
                    <div class="author-avatar" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">IT</div>
                    <div style="display: flex; flex-direction: column;">
                        <span class="author-name">IndoTechSec</span>
                        <span class="post-time">Posted 1 day ago</span>
                    </div>
                </div>
                
                <h3 class="thread-title">Diskusi: Sertifikasi CEH vs OSCP untuk pemula di 2025</h3>
                <p class="thread-excerpt">
                    Budget terbatas tapi ingin switch career ke cyber security. Lebih worth it ambil CEH dulu untuk fundamental atau langsung OSCP 
                    biar hands-on? Mohon masukannya para sepuh.
                </p>

                <div class="thread-footer">
                    <div class="tags-group">
                        <span class="tag-pill">#Career</span>
                        <span class="tag-pill">#Certification</span>
                    </div>
                    <div class=\"stats-group\">
                        <div class="stat-item"><ion-icon name="chatbox-outline"></ion-icon> 89 Replies</div>
                        <div class="stat-item"><ion-icon name="eye-outline"></ion-icon> 5.6k Views</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="thread-meta">
                    <div class="author-avatar" style="background: linear-gradient(135deg, #10b981, #059669);">R</div>
                    <div style="display: flex; flex-direction: column;">
                        <span class="author-name">RootAccess_01</span>
                        <span class="post-time">Posted 2 hours ago</span>
                    </div>
                </div>
                
                <h3 class="thread-title">[ASK] Cara bypass WAF Cloudflare pada target DVWA?</h3>
                <p class="thread-excerpt">
                    Saya sedang melakukan pentest legal pada server kantor sendiri yang dipasang DVWA untuk latihan team. 
                    Namun payload XSS standar selalu terblokir. Ada referensi bypass technique terbaru?
                </p>

                <div class="thread-footer">
                    <div class="tags-group">
                        <span class="tag-pill">#WebSec</span>
                        <span class="tag-pill">#Pentest</span>
                    </div>
                    <div class="stats-group">
                        <div class="stat-item"><ion-icon name="chatbox-outline"></ion-icon> 12 Replies</div>
                        <div class="stat-item"><ion-icon name="eye-outline"></ion-icon> 800 Views</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>