<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tachyon | Mulai Diskusi</title>
    <link rel="stylesheet" href="{{ asset('css/topik.css') }}">
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
            <h2 class="page-title">Mulai Diskusi</h2>

            <form action="{{ route('forum.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="topic">
                
                <div class="form-group">
                    <label>Topik Diskusi</label>
                    <input type="text" name="title" placeholder="Apa yang ingin didiskusikan?" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <div class="custom-select-wrapper">
                        <select name="category_id" required>
                            <option value="" disabled selected>Pilih Kategori...</option>
                            <option value="question">Q&A</option>
                            <option value="discussion">General Discussion</option>
                            <option value="news">News</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Detail</label>
                    <textarea name="content" rows="6" placeholder="Ceritakan detailnya..." required></textarea>
                </div>

                <div class="attachment-bar">
                    <label class="btn-attach" style="cursor: pointer;">
                        <input type="file" name="image" style="display: none;" accept="image/*">
                        <ion-icon name="image-outline"></ion-icon> Tambah Gambar
                    </label>
                </div>

                <div class="form-actions">
                    <a href="{{ route('forum') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Posting Topik</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>