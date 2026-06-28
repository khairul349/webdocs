<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WebDocs — Tulis dan kelola dokumen Anda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f4f6fb; min-height: 100vh; color: #1a1f36; }

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
            flex-shrink: 0;
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
        .nav-actions { display: flex; align-items: center; gap: 10px; }
        .btn-ghost {
            font-size: 13.5px; font-weight: 600; color: #4a5068;
            text-decoration: none; padding: 9px 16px; border-radius: 10px;
            transition: background 0.15s;
        }
        .btn-ghost:hover { background: #f4f6fb; color: #1a1f36; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 13.5px; font-weight: 600; color: #fff; text-decoration: none;
            padding: 10px 20px; border-radius: 10px;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            box-shadow: 0 4px 16px rgba(79,142,247,0.35);
            transition: all 0.2s;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(79,142,247,0.45); }
        .btn-primary:active { transform: translateY(0); }

        /* Hero */
        .hero {
            max-width: 1200px; margin: 0 auto;
            padding: 90px 28px 60px;
            text-align: center;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 12px; font-weight: 700; color: #7c3aed;
            background: #f0ebff; border-radius: 20px; padding: 6px 14px;
            margin-bottom: 24px; letter-spacing: 0.3px;
        }
        .hero h1 {
            font-size: 48px; font-weight: 800; letter-spacing: -1px;
            line-height: 1.15; color: #1a1f36; margin-bottom: 18px;
        }
        .hero h1 span {
            background: linear-gradient(90deg, #4f8ef7, #7c3aed);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero p {
            font-size: 17px; color: #6b7390; max-width: 560px;
            margin: 0 auto 36px; line-height: 1.6;
        }
        .hero-actions { display: flex; align-items: center; justify-content: center; gap: 14px; flex-wrap: wrap; }
        .btn-lg {
            font-size: 15px; padding: 13px 28px; border-radius: 12px;
        }

        /* Preview card */
        .preview-wrap { max-width: 920px; margin: 64px auto 0; padding: 0 28px; }
        .preview-card {
            background: #fff; border: 1px solid #e8ecf4; border-radius: 20px;
            box-shadow: 0 20px 60px rgba(30,40,80,0.10);
            overflow: hidden;
        }
        .preview-bar {
            display: flex; align-items: center; gap: 8px;
            padding: 14px 18px; border-bottom: 1px solid #f0f2f8;
        }
        .preview-dot { width: 10px; height: 10px; border-radius: 50%; }
        .preview-body { padding: 32px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .preview-doc {
            background: linear-gradient(145deg, #f7f9ff, #eef2ff);
            border-radius: 14px; padding: 18px; height: 120px; position: relative;
        }
        .preview-line { height: 6px; border-radius: 3px; background: #d8e0f7; margin-bottom: 8px; }
        .preview-line.title { background: linear-gradient(90deg, #4f8ef7, #7c3aed); width: 60%; height: 8px; }
        .preview-line.w90 { width: 90%; }
        .preview-line.w70 { width: 70%; }
        .preview-line.w50 { width: 50%; }

        @media (max-width: 768px) {
            .preview-body { grid-template-columns: 1fr; }
        }

        /* Features */
        .features {
            max-width: 1000px; margin: 0 auto; padding: 80px 28px 40px;
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
        }
        .feature-card {
            background: #fff; border: 1px solid #e8ecf4; border-radius: 16px;
            padding: 26px 24px;
        }
        .feature-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
        }
        .feature-title { font-size: 15.5px; font-weight: 700; color: #1a1f36; margin-bottom: 8px; }
        .feature-sub { font-size: 13.5px; color: #8a92b0; line-height: 1.6; }

        @media (max-width: 768px) {
            .hero h1 { font-size: 34px; }
            .hero { padding: 60px 24px 40px; }
            .features { grid-template-columns: 1fr; padding: 60px 24px 20px; }
            .nav-actions .btn-ghost { display: none; }
        }

        /* Footer */
        .footer {
            text-align: center; padding: 50px 24px 40px;
            font-size: 13px; color: #9199b8;
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ url('/') }}" class="nav-logo">
            <div class="nav-logo-icon">
                <svg width="18" height="18" fill="white" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zm0 2.5L18.5 9H14z"/>
                </svg>
            </div>
            <span class="nav-logo-text">WebDocs</span>
            <span class="nav-badge">BETA</span>
        </a>

        <div class="nav-actions">
            @auth
                <a href="{{ route('documents.index') }}" class="btn-primary">Buka Dashboard</a>
            @else
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-primary">Daftar Gratis</a>
                @endif
            @endauth
        </div>
    </div>
</nav>

{{-- Hero --}}
<div class="hero">
    <span class="hero-badge">✨ Menulis jadi lebih ringan</span>
    <h1>Satu tempat untuk<br><span>menulis &amp; mengelola</span> dokumen Anda</h1>
    <p>WebDocs membantu Anda menulis, menyimpan, dan berbagi dokumen secara real-time — rapi, cepat, dan bisa diakses dari mana saja.</p>
    <div class="hero-actions">
        @auth
            <a href="{{ route('documents.index') }}" class="btn-primary btn-lg">Buka Dashboard</a>
        @else
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-primary btn-lg">Mulai Menulis — Gratis</a>
            @endif
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="btn-ghost btn-lg">Sudah punya akun? Masuk</a>
            @endif
        @endauth
    </div>
</div>

{{-- Preview --}}
<div class="preview-wrap">
    <div class="preview-card">
        <div class="preview-bar">
            <span class="preview-dot" style="background:#ff5f57;"></span>
            <span class="preview-dot" style="background:#febc2e;"></span>
            <span class="preview-dot" style="background:#28c840;"></span>
        </div>
        <div class="preview-body">
            <div class="preview-doc">
                <div class="preview-line title"></div>
                <div class="preview-line w90"></div>
                <div class="preview-line w70"></div>
                <div class="preview-line w50"></div>
            </div>
            <div class="preview-doc">
                <div class="preview-line title"></div>
                <div class="preview-line w70"></div>
                <div class="preview-line w90"></div>
                <div class="preview-line w50"></div>
            </div>
            <div class="preview-doc">
                <div class="preview-line title"></div>
                <div class="preview-line w50"></div>
                <div class="preview-line w90"></div>
                <div class="preview-line w70"></div>
            </div>
        </div>
    </div>
</div>

{{-- Features --}}
<div class="features">
    <div class="feature-card">
        <div class="feature-icon" style="background:#eef4ff;">
            <svg width="20" height="20" fill="none" stroke="#4f8ef7" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
        </div>
        <div class="feature-title">Menulis tanpa batas</div>
        <div class="feature-sub">Buat dokumen sebanyak yang Anda mau, tersimpan otomatis setiap saat.</div>
    </div>
    <div class="feature-card">
        <div class="feature-icon" style="background:#f0ebff;">
            <svg width="20" height="20" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <div class="feature-title">Kolaborasi real-time</div>
        <div class="feature-sub">Undang rekan kerja dan tulis bersama dalam dokumen yang sama, secara langsung.</div>
    </div>
    <div class="feature-card">
        <div class="feature-icon" style="background:#fff4eb;">
            <svg width="20" height="20" fill="none" stroke="#f59e42" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
            </svg>
        </div>
        <div class="feature-title">Riwayat tersimpan</div>
        <div class="feature-sub">Lihat dan kembali ke versi sebelumnya kapan pun Anda butuhkan.</div>
    </div>
</div>

{{-- Footer --}}
<div class="footer">
    &copy; {{ date('Y') }} WebDocs. Dibuat dengan Laravel.
</div>

</body>
</html>