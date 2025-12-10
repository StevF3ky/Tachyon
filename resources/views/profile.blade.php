<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tachyon | Edit Profile</title>
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
        <header>
            <div class="left-controls">
                <ion-icon name="menu-outline" style="font-size: 24px; color: white; display: none;"></ion-icon>
            </div>
        </header>

        <div class="edit-container">
            <div class="section-header">
                <h2 class="section-title">Edit Profile</h2>
                <p class="section-desc">Perbarui informasi profil dan preferensi tampilan Anda.</p>
                
                @if (session('status') === 'profile-updated')
                    <p style="color: #4ade80; margin-top: 10px; font-size: 14px;">
                        Profile updated successfully.
                    </p>
                @endif
            </div>

            <div class="edit-card">
                <div class="banner-edit-wrapper">
                    <div class="banner-overlay">
                        <ion-icon name="camera-outline" style="font-size: 32px; color: white;"></ion-icon>
                    </div>
                    
                    <div class="avatar-edit-wrapper">
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 24px; color: white; background-color: #06b6d4;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div class="avatar-edit-overlay">
                            <ion-icon name="camera-outline" style="font-size: 24px; color: white;"></ion-icon>
                        </div>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('patch')

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Display Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <span style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</span>
                            @enderror
                        </div>


                        
                        <div class="form-group full">
                            <label for="bio">Bio</label>
                            <textarea id="bio" name="bio" rows="4" placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $user->bio ?? '') }}</textarea>
                             @error('bio')
                                <span style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full">
                            <label for="location">Location</label>
                            <input type="text" id="location" name="location" value="{{ old('location', $user->location ?? '') }}">
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('profile.show') }}" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-save">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>