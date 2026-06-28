<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WebDocs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f4f6fb; min-height: 100vh; }

        /* Navbar */
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e8ecf4;
            position: sticky; top: 0; z-index: 50;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        }
        .navbar-inner {
            max-width: 1200px; margin: 0 auto;
            padding: 0 28px; height: 62px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-logo {
            display: flex; align-items: center; gap: 10px; text-decoration: none;
        }
        .nav-logo-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(79,142,247,0.35);
        }
        .nav-logo-text {
            font-size: 16px; font-weight: 800; color: #1a1f36;
            letter-spacing: -0.4px;
        }
        .nav-badge {
            font-size: 10px; font-weight: 700; color: #4f8ef7;
            background: #eef4ff; border-radius: 20px;
            padding: 2px 8px; letter-spacing: 0.5px;
        }

        /* Search */
        .search-wrap { position: relative; width: 300px; }
        .search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); }
        .search-input {
            width: 100%; padding: 9px 14px 9px 38px;
            background: #f4f6fb; border: 1px solid #e4e8f2;
            border-radius: 10px; font-size: 13.5px; color: #3a3f5c;
            outline: none; font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }
        .search-input:focus {
            background: #fff; border-color: #4f8ef7;
            box-shadow: 0 0 0 3px rgba(79,142,247,0.12);
        }
        .search-input::placeholder { color: #a0a8c0; }

        /* Avatar button */
        .user-btn {
            display: flex; align-items: center; gap: 9px;
            background: transparent; border: none; cursor: pointer;
            padding: 6px 10px; border-radius: 12px; transition: background 0.15s;
            position: relative;
        }
        .user-btn:hover { background: #f4f6fb; }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; color: white; flex-shrink: 0;
        }
        .user-name { font-size: 13px; font-weight: 600; color: #1a1f36; }
        .user-sub { font-size: 11px; color: #9199b8; margin-top: 1px; }
        .user-dropdown {
            display: none; position: absolute; right: 0; top: calc(100% + 8px);
            background: #fff; border: 1px solid #e8ecf4; border-radius: 14px;
            padding: 8px; min-width: 220px;
            box-shadow: 0 12px 36px rgba(30,40,80,0.12); z-index: 100;
        }
        .dropdown-header {
            padding: 10px 12px 12px; border-bottom: 1px solid #f0f2f8; margin-bottom: 6px;
        }
        .dropdown-header p:first-child { font-size: 13px; font-weight: 700; color: #1a1f36; }
        .dropdown-header p:last-child { font-size: 11px; color: #9199b8; margin-top: 3px; }
        .dropdown-item {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 12px; border-radius: 8px; font-size: 13px;
            color: #4a5068; font-weight: 500; text-decoration: none;
            transition: background 0.15s; cursor: pointer;
            background: transparent; border: none; width: 100%;
            font-family: 'Inter', sans-serif;
        }
        .dropdown-item:hover { background: #f4f6fb; color: #1a1f36; }
        .dropdown-item.danger { color: #e85555; }
        .dropdown-item.danger:hover { background: #fff0f0; }

        /* Main */
        .main { max-width: 1200px; margin: 0 auto; padding: 40px 28px 60px; }

        /* Page title area */
        .page-header {
            display: flex; align-items: flex-end; justify-content: space-between;
            margin-bottom: 36px; flex-wrap: wrap; gap: 16px;
        }
        .greeting { font-size: 26px; font-weight: 800; color: #1a1f36; letter-spacing: -0.5px; }
        .greeting span {
            background: linear-gradient(90deg, #4f8ef7, #7c3aed);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .greeting-sub { font-size: 14px; color: #8a92b0; margin-top: 4px; }

        /* New doc button */
        .btn-new {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 22px; border-radius: 12px; font-size: 14px; font-weight: 600;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            color: white; border: none; cursor: pointer;
            box-shadow: 0 4px 16px rgba(79,142,247,0.35);
            transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .btn-new:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(79,142,247,0.45); }
        .btn-new:active { transform: translateY(0); }

        /* Stats row */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 36px; }
        .stat-card {
            background: #fff; border: 1px solid #e8ecf4; border-radius: 16px;
            padding: 20px 24px; display: flex; align-items: center; gap: 16px;
        }
        .stat-icon {
            width: 46px; height: 46px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .stat-value { font-size: 24px; font-weight: 800; color: #1a1f36; line-height: 1; }
        .stat-label { font-size: 13px; color: #8a92b0; margin-top: 4px; }

        /* Section header */
        .section-header {
            display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;
        }
        .section-title { font-size: 16px; font-weight: 700; color: #1a1f36; }
        .count-pill {
            font-size: 12px; font-weight: 600; color: #6b74a0;
            background: #eef0f8; border-radius: 20px; padding: 3px 10px;
        }

        /* Document grid */
        .doc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; }
        .doc-card {
            background: #fff; border: 1px solid #e8ecf4; border-radius: 16px;
            overflow: hidden; transition: all 0.2s; cursor: pointer;
            text-decoration: none; display: block;
        }
        .doc-card:hover {
            border-color: #c0cef5; transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(79,142,247,0.12);
        }
        .doc-preview {
            height: 130px; background: linear-gradient(145deg, #f7f9ff, #eef2ff);
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }
        .doc-lines {
            position: absolute; left: 20px; right: 20px; top: 20px; bottom: 20px;
            display: flex; flex-direction: column; gap: 7px;
        }
        .doc-line { height: 5px; border-radius: 3px; background: #d8e0f7; }
        .doc-line.title { background: linear-gradient(90deg, #4f8ef7, #7c3aed); width: 65%; height: 7px; }
        .doc-line.w90 { width: 90%; }
        .doc-line.w75 { width: 75%; }
        .doc-line.w55 { width: 55%; }
        .doc-line.w80 { width: 80%; }
        .doc-body { padding: 14px 16px; }
        .doc-title {
            font-size: 14px; font-weight: 600; color: #1a1f36;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            margin-bottom: 6px;
        }
        .doc-meta {
            display: flex; align-items: center; justify-content: space-between;
        }
        .doc-time { font-size: 12px; color: #9199b8; display: flex; align-items: center; gap: 5px; }
        .doc-delete {
            width: 28px; height: 28px; border-radius: 8px; border: 1px solid #e8ecf4;
            background: transparent; display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.15s; color: #b0b8d8; flex-shrink: 0;
        }
        .doc-delete:hover { background: #fff0f0; border-color: #fcc; color: #e85555; }

        /* Empty state */
        .empty-state {
            grid-column: 1 / -1; text-align: center; padding: 70px 24px;
            background: #fff; border: 2px dashed #dde3f5; border-radius: 20px;
        }
        .empty-icon {
            width: 70px; height: 70px; border-radius: 20px;
            background: linear-gradient(135deg, #eef4ff, #f0ebff);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
        }
        .empty-title { font-size: 18px; font-weight: 700; color: #1a1f36; margin-bottom: 8px; }
        .empty-sub { font-size: 14px; color: #9199b8; margin-bottom: 28px; }

        @media (max-width: 768px) {
            .search-wrap { display: none; }
            .stats-row { grid-template-columns: 1fr 1fr; }
            .stats-row .stat-card:last-child { grid-column: 1/-1; }
            .doc-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 480px) {
            .main { padding: 24px 16px 60px; }
            .doc-grid { grid-template-columns: 1fr; }
            .page-header { align-items: flex-start; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('documents.index') }}" class="nav-logo">
            <div class="nav-logo-icon">
                <svg width="18" height="18" fill="white" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zm0 2.5L18.5 9H14z"/>
                </svg>
            </div>
            <span class="nav-logo-text">WebDocs</span>
            <span class="nav-badge">BETA</span>
        </a>

        <div class="search-wrap">
            <svg width="14" height="14" fill="none" stroke="#a0a8c0" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input class="search-input" type="text" placeholder="Cari dokumen..."
                oninput="filterDocs(this.value)">
        </div>

        <div style="position: relative;">
            <button class="user-btn" onclick="toggleMenu()" id="user-btn">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-sub">Personal workspace</div>
                </div>
                <svg width="13" height="13" fill="none" stroke="#9199b8" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M6 9l6 6 6-6"/>
                </svg>
            </button>
            <div class="user-dropdown" id="user-menu">
                <div class="dropdown-header">
                    <p>{{ Auth::user()->name }}</p>
                    <p>{{ Auth::user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                    Edit Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item danger">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

{{-- Main --}}
<div class="main">

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <div class="greeting">
                Halo, <span>{{ explode(' ', Auth::user()->name)[0] }}</span> 👋
            </div>
            <div class="greeting-sub">Kelola dan tulis semua dokumen Anda di sini.</div>
        </div>
        <form action="{{ route('documents.store') }}" method="POST">
            @csrf
            <button type="submit" class="btn-new">
                <svg width="16" height="16" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Dokumen Baru
            </button>
        </form>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: #eef4ff;">
                <svg width="22" height="22" fill="none" stroke="#4f8ef7" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $documents->count() }}</div>
                <div class="stat-label">Total Dokumen</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #f0ebff;">
                <svg width="22" height="22" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ $documents->where('created_at', '>=', now()->startOfDay())->count() }}</div>
                <div class="stat-label">Dibuat Hari Ini</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fff4eb;">
                <svg width="22" height="22" fill="none" stroke="#f59e42" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                </svg>
            </div>
            <div>
                <div class="stat-value" style="font-size: 15px; padding-top: 4px;">
                    {{ $documents->isNotEmpty() ? $documents->sortByDesc('updated_at')->first()->updated_at->diffForHumans() : '—' }}
                </div>
                <div class="stat-label">Terakhir Diubah</div>
            </div>
        </div>
    </div>

    {{-- Documents --}}
    <div class="section-header">
        <span class="section-title">Dokumen Saya</span>
        @if($documents->count() > 0)
            <span class="count-pill">{{ $documents->count() }} dokumen</span>
        @endif
    </div>

    <div class="doc-grid" id="doc-grid">
        @forelse($documents as $doc)
        <div class="doc-card" data-title="{{ strtolower($doc->title) }}">
            <a href="{{ route('documents.show', $doc->id) }}" style="text-decoration: none; display: block;">
                <div class="doc-preview">
                    <div class="doc-lines">
                        <div class="doc-line title"></div>
                        <div class="doc-line w90"></div>
                        <div class="doc-line w75"></div>
                        <div class="doc-line w55"></div>
                        <div class="doc-line w80"></div>
                    </div>
                </div>
            </a>
            <div class="doc-body">
                <div class="doc-title">{{ $doc->title ?: 'Untitled Document' }}</div>
                <div class="doc-meta">
                    <div class="doc-time">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                        </svg>
                        {{ $doc->created_at->diffForHumans() }}
                    </div>
                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="doc-delete" onclick="return confirm('Hapus dokumen ini?')" title="Hapus">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 6h18M19 6l-1 14H6L5 6M9 6V4h6v2"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="32" height="32" fill="none" stroke="#7c3aed" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <path d="M14 2v6h6M12 18v-6M9 15h6"/>
                </svg>
            </div>
            <div class="empty-title">Belum ada dokumen</div>
            <div class="empty-sub">Buat dokumen pertama Anda sekarang</div>
            <form action="{{ route('documents.store') }}" method="POST">
                @csrf
                <button type="submit" class="btn-new">
                    <svg width="15" height="15" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Buat Sekarang
                </button>
            </form>
        </div>
        @endforelse
    </div>

</div>

<script>
    // User dropdown toggle
    function toggleMenu() {
        const menu = document.getElementById('user-menu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }
    document.addEventListener('click', function(e) {
        const btn = document.getElementById('user-btn');
        const menu = document.getElementById('user-menu');
        if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = 'none';
        }
    });

    // Live search filter
    function filterDocs(query) {
        const cards = document.querySelectorAll('#doc-grid .doc-card');
        const q = query.toLowerCase().trim();
        cards.forEach(card => {
            const title = card.getAttribute('data-title') || '';
            card.style.display = (!q || title.includes(q)) ? 'block' : 'none';
        });
    }
</script>

</body>
</html>