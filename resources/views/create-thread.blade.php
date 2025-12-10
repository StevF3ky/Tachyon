<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tachyon | Tulis Artikel</title>
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
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
        <div class="create-container">
            <h2 class="page-title">Tulis Artikel Baru</h2>

            <form action="{{ route('forum.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="article">
                <div class="form-group">
                    <label>Judul Artikel <span class="required">*</span></label>
                    <input type="text" name="title" required>
                </div>

                <div class="form-group">
                    <label>Kategori <span class="required">*</span></label>
                    <div class="custom-select-wrapper">
                        <select name="category_id" required style="width: 100%; padding: 10px; background: #0f172a; color: white; border: 1px solid #1e293b; border-radius: 8px;">
                            <option value="" disabled selected>Pilih Kategori...</option>
                            <option value="cyber-security">Cyber Security</option>
                            <option value="web-dev">Web Development</option>
                            <option value="hardware">Hardware</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Konten Artikel <span class="required">*</span></label>
                    <textarea name="content" rows="15" required></textarea>
                </div>

                <div class="form-group">
                    <label>Cover Image</label>
                    <div class="media-upload-area">
                        <input type="file" name="image" class="file-input" accept="image/*">
                        <div class="upload-content">
                            <p class="upload-text">Klik untuk upload cover artikel</p>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('home') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Publish Artikel</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>