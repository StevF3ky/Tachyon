<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tachyon | Profil Saya</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
            <a href="{{ route('library') }}" class="nav-item">
                <ion-icon name="library-outline"></ion-icon> Library Saya
            </a>
        </div>
        
        <div class="sidebar-footer" style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
            <div class="user-profile">
                <div class="avatar" style="width: 35px; height: 35px; background: #06b6d4; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div style="flex: 1; overflow: hidden; margin-left: 10px;">
                    <h4 style="color: white; font-size: 14px; font-weight: 600;">{{ Auth::user()->name }}</h4>
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
        
        <div style="max-width: 1000px; margin: 0 auto;">
            
            <div class="profile-header-card">
                <div class="profile-banner"></div>
                
                <div class="profile-info-section">
                    <div class="profile-identity">
                        <div class="profile-avatar-large">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="profile-names">
                            <h1>{{ Auth::user()->name }} <ion-icon name="checkmark-circle" class="badge-verified"></ion-icon></h1>
                            <p>
                                {{ '@' . strtolower(str_replace(' ', '_', Auth::user()->name)) }} 
                                <span style="margin: 0 8px;">•</span> 
                                Joined {{ Auth::user()->created_at->format('F Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="profile-actions">
                        <a href="{{ route('profile.edit') }}" class="btn-edit" style="text-decoration: none;">
                            <ion-icon name="settings-outline"></ion-icon> Edit Profile
                        </a>
                    </div>
                </div>

                <div class="profile-bio-stats">
                    <p class="bio-text">
                        Cyber Security Enthusiast 🛡️ | CTF Player | Learning Web Exploitation & Network Defense. 
                        "Security is a process, not a product."
                    </p>
                </div>
            </div>

            <div class="profile-feed">
                <h3 style="color: white; margin-bottom: 20px; font-size: 18px;">Recent Activity</h3>
                
                <article class="card">
                    <div class="card-header">
                        <div class="author-avatar" style="background: #06b6d4;">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        <div class="author-info">
                            <h4>{{ Auth::user()->name }}</h4>
                            <span>2 jam yang lalu</span>
                        </div>
                        <ion-icon name="ellipsis-horizontal" style="margin-left: auto; color: var(--text-muted); cursor: pointer;"></ion-icon>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">My First CTF Writeup: HackTheBox Machine</h3>
                        <p class="card-excerpt">
                            Baru saja menyelesaikan mesin 'Easy' di HTB. Berikut adalah langkah-langkah yang saya lakukan mulai dari enumerasi nmap hingga privilege escalation.
                        </p>
                    </div>
                    <div class="card-actions">
                        <div style="display: flex; gap: 20px;">
                            <button class="action-btn"><ion-icon name="heart-outline"></ion-icon> 24</button>
                            <button class="action-btn"><ion-icon name="chatbubble-outline"></ion-icon> 5</button>
                        </div>
                        <span class="tag-pill">Writeup</span>
                    </div>
                </article>

                <article class="card">
                    <div class="card-header">
                        <div class="author-avatar" style="background: #06b6d4;">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        <div class="author-info">
                            <h4>{{ Auth::user()->name }}</h4>
                            <span>1 hari yang lalu</span>
                        </div>
                        <ion-icon name="ellipsis-horizontal" style="margin-left: auto; color: var(--text-muted); cursor: pointer;"></ion-icon>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Tanya: Rekomendasi Laptop untuk Kali Linux?</h3>
                        <p class="card-excerpt">
                            Budget sekitar 10-15 juta. Perlu yang support monitor mode untuk WiFi card internalnya kalau bisa. Ada saran?
                        </p>
                    </div>
                    <div class="card-actions">
                        <div style="display: flex; gap: 20px;">
                            <button class="action-btn"><ion-icon name="heart-outline"></ion-icon> 12</button>
                            <button class="action-btn"><ion-icon name="chatbubble-outline"></ion-icon> 18</button>
                        </div>
                        <span class="tag-pill">Hardware</span>
                    </div>
                </article>

            </div>
        </div>
    </div>

</body>
</html>