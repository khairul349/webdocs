<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Profil — WebDocs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f4f6fb; min-height: 100vh; }

        /* Navbar */
        .navbar {
            background: #fff; border-bottom: 1px solid #e8ecf4;
            position: sticky; top: 0; z-index: 50;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        }
        .navbar-inner {
            max-width: 1200px; margin: 0 auto;
            padding: 0 28px; height: 62px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-logo-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(79,142,247,0.35);
        }
        .nav-logo-text { font-size: 16px; font-weight: 800; color: #1a1f36; letter-spacing: -0.4px; }
        .nav-badge {
            font-size: 10px; font-weight: 700; color: #4f8ef7;
            background: #eef4ff; border-radius: 20px; padding: 2px 8px; letter-spacing: 0.5px;
        }
        .user-btn {
            display: flex; align-items: center; gap: 9px;
            background: transparent; border: none; cursor: pointer;
            padding: 6px 10px; border-radius: 12px; transition: background 0.15s; position: relative;
        }
        .user-btn:hover { background: #f4f6fb; }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; color: white;
        }
        .user-name { font-size: 13px; font-weight: 600; color: #1a1f36; }
        .user-sub { font-size: 11px; color: #9199b8; margin-top: 1px; }
        .user-dropdown {
            display: none; position: absolute; right: 0; top: calc(100% + 8px);
            background: #fff; border: 1px solid #e8ecf4; border-radius: 14px;
            padding: 8px; min-width: 220px;
            box-shadow: 0 12px 36px rgba(30,40,80,0.12); z-index: 100;
        }
        .dropdown-header { padding: 10px 12px 12px; border-bottom: 1px solid #f0f2f8; margin-bottom: 6px; }
        .dropdown-header p:first-child { font-size: 13px; font-weight: 700; color: #1a1f36; }
        .dropdown-header p:last-child { font-size: 11px; color: #9199b8; margin-top: 3px; }
        .dropdown-item {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 12px; border-radius: 8px; font-size: 13px;
            color: #4a5068; font-weight: 500; text-decoration: none;
            transition: background 0.15s; cursor: pointer;
            background: transparent; border: none; width: 100%;
            font-family: 'Inter', sans-serif; text-align: left;
        }
        .dropdown-item:hover { background: #f4f6fb; color: #1a1f36; }
        .dropdown-item.danger { color: #e85555; }
        .dropdown-item.danger:hover { background: #fff0f0; }

        /* Main */
        .main { max-width: 820px; margin: 0 auto; padding: 44px 28px 80px; }

        /* Back link */
        .back-link {
            display: inline-flex; align-items: center; gap: 7px;
            color: #8a92b0; font-size: 13px; font-weight: 500;
            text-decoration: none; margin-bottom: 28px;
            transition: color 0.15s;
        }
        .back-link:hover { color: #4f8ef7; }

        /* Page title */
        .page-title { font-size: 26px; font-weight: 800; color: #1a1f36; letter-spacing: -0.5px; margin-bottom: 6px; }
        .page-sub { font-size: 14px; color: #8a92b0; margin-bottom: 36px; }

        /* Avatar section */
        .avatar-section {
            background: linear-gradient(135deg, #eef4ff 0%, #f0ebff 100%);
            border: 1px solid #dde5f8; border-radius: 20px;
            padding: 28px 32px; display: flex; align-items: center; gap: 24px;
            margin-bottom: 24px;
        }
        .avatar-big {
            width: 72px; height: 72px; border-radius: 50%;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 28px; color: white;
            box-shadow: 0 8px 24px rgba(79,142,247,0.35); flex-shrink: 0;
        }
        .avatar-info h3 { font-size: 18px; font-weight: 700; color: #1a1f36; margin-bottom: 4px; }
        .avatar-info p { font-size: 13px; color: #8a92b0; }
        .avatar-badge {
            margin-left: auto; background: #fff; border: 1px solid #dde5f8;
            color: #4f8ef7; font-size: 12px; font-weight: 600;
            padding: 5px 14px; border-radius: 20px;
        }

        /* Card */
        .card {
            background: #fff; border: 1px solid #e8ecf4; border-radius: 20px;
            padding: 32px; margin-bottom: 20px;
        }
        .card-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .card-icon {
            width: 42px; height: 42px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .card-title { font-size: 16px; font-weight: 700; color: #1a1f36; margin-bottom: 3px; }
        .card-desc { font-size: 13px; color: #9199b8; }

        /* Form elements */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block; font-size: 13px; font-weight: 600;
            color: #4a5068; margin-bottom: 8px;
        }
        .form-input {
            width: 100%; padding: 11px 16px;
            background: #f7f9ff; border: 1.5px solid #e4e8f2;
            border-radius: 12px; font-size: 14px; color: #1a1f36;
            font-family: 'Inter', sans-serif; outline: none;
            transition: all 0.2s;
        }
        .form-input:focus {
            background: #fff; border-color: #4f8ef7;
            box-shadow: 0 0 0 3px rgba(79,142,247,0.12);
        }
        .form-input::placeholder { color: #b0b8d4; }
        .form-error { font-size: 12px; color: #e85555; margin-top: 6px; }
        .form-hint { font-size: 12px; color: #9199b8; margin-top: 6px; }

        /* Buttons */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 24px; border-radius: 12px; font-size: 14px; font-weight: 600;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            color: white; border: none; cursor: pointer;
            box-shadow: 0 4px 14px rgba(79,142,247,0.3);
            transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(79,142,247,0.4); }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 24px; border-radius: 12px; font-size: 14px; font-weight: 600;
            background: #f4f6fb; color: #4a5068; border: 1.5px solid #e4e8f2;
            cursor: pointer; transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .btn-secondary:hover { background: #eef0f8; color: #1a1f36; }
        .btn-danger {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 24px; border-radius: 12px; font-size: 14px; font-weight: 600;
            background: #fff0f0; color: #e85555;
            border: 1.5px solid #fcc; cursor: pointer;
            transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .btn-danger:hover { background: #e85555; color: white; border-color: #e85555; }

        .btn-row { display: flex; align-items: center; gap: 12px; margin-top: 8px; }
        .saved-msg {
            font-size: 13px; color: #22c55e; font-weight: 500;
            display: flex; align-items: center; gap: 6px;
        }

        /* Danger zone */
        .danger-zone {
            background: #fff8f8; border: 1.5px solid #fcc; border-radius: 20px;
            padding: 32px; margin-bottom: 20px;
        }
        .danger-zone .card-icon { background: #fff0f0; }

        /* Modal overlay */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(15,20,50,0.5); z-index: 200;
            align-items: center; justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: #fff; border-radius: 20px; padding: 36px;
            max-width: 480px; width: 90%; box-shadow: 0 24px 60px rgba(0,0,0,0.18);
            animation: slideUp 0.25s ease;
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to   { transform: translateY(0);   opacity: 1; }
        }
        .modal-title { font-size: 18px; font-weight: 700; color: #1a1f36; margin-bottom: 8px; }
        .modal-desc { font-size: 14px; color: #8a92b0; line-height: 1.6; margin-bottom: 24px; }
        .modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px; }

        @media (max-width: 600px) {
            .main { padding: 28px 16px 60px; }
            .avatar-section { flex-wrap: wrap; }
            .avatar-badge { margin-left: 0; }
            .card { padding: 24px 20px; }
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

    {{-- Back --}}
    <a href="{{ route('documents.index') }}" class="back-link">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Kembali ke Dashboard
    </a>

    <h1 class="page-title">Pengaturan Akun</h1>
    <p class="page-sub">Kelola informasi profil dan keamanan akun Anda.</p>

    {{-- Avatar Card --}}
    <div class="avatar-section">
        <div class="avatar-big">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="avatar-info">
            <h3>{{ Auth::user()->name }}</h3>
            <p>{{ Auth::user()->email }}</p>
        </div>
        <span class="avatar-badge">✓ Akun Aktif</span>
    </div>

    {{-- Profile Info Form --}}
    <div class="card">
        <div class="card-header">
            <div class="card-icon" style="background: #eef4ff;">
                <svg width="20" height="20" fill="none" stroke="#4f8ef7" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div>
                <div class="card-title">Informasi Profil</div>
                <div class="card-desc">Perbarui nama dan alamat email akun Anda.</div>
            </div>
        </div>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="form-group">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input class="form-input" id="name" name="name" type="text"
                    value="{{ old('name', $user->name) }}" required autocomplete="name"
                    placeholder="Masukkan nama lengkap Anda">
                @if ($errors->get('name'))
                    @foreach ($errors->get('name') as $error)
                        <p class="form-error">{{ $error }}</p>
                    @endforeach
                @endif
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <input class="form-input" id="email" name="email" type="email"
                    value="{{ old('email', $user->email) }}" required autocomplete="username"
                    placeholder="nama@email.com">
                @if ($errors->get('email'))
                    @foreach ($errors->get('email') as $error)
                        <p class="form-error">{{ $error }}</p>
                    @endforeach
                @endif

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <p class="form-hint">
                        Email belum diverifikasi.
                        <button form="send-verification" style="color: #4f8ef7; background: none; border: none; cursor: pointer; font-size: 12px; font-family: inherit; font-weight: 500;">
                            Kirim ulang email verifikasi
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="form-hint" style="color: #22c55e;">Link verifikasi baru telah dikirim.</p>
                    @endif
                @endif
            </div>

            <div class="btn-row">
                <button type="submit" class="btn-primary">
                    <svg width="15" height="15" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Perubahan
                </button>
                @if (session('status') === 'profile-updated')
                    <span class="saved-msg"
                        x-data="{ show: true }" x-show="show" x-transition
                        x-init="setTimeout(() => show = false, 2000)">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                        Tersimpan!
                    </span>
                @endif
            </div>
        </form>
    </div>

    {{-- Password Form --}}
    <div class="card">
        <div class="card-header">
            <div class="card-icon" style="background: #f0ebff;">
                <svg width="20" height="20" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            <div>
                <div class="card-title">Ubah Password</div>
                <div class="card-desc">Gunakan password panjang dan acak agar akun tetap aman.</div>
            </div>
        </div>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="form-group">
                <label class="form-label" for="current_password">Password Saat Ini</label>
                <input class="form-input" id="current_password" name="current_password"
                    type="password" autocomplete="current-password" placeholder="••••••••">
                @if ($errors->updatePassword->get('current_password'))
                    @foreach ($errors->updatePassword->get('current_password') as $error)
                        <p class="form-error">{{ $error }}</p>
                    @endforeach
                @endif
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password Baru</label>
                <input class="form-input" id="password" name="password"
                    type="password" autocomplete="new-password" placeholder="••••••••">
                @if ($errors->updatePassword->get('password'))
                    @foreach ($errors->updatePassword->get('password') as $error)
                        <p class="form-error">{{ $error }}</p>
                    @endforeach
                @endif
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                <input class="form-input" id="password_confirmation" name="password_confirmation"
                    type="password" autocomplete="new-password" placeholder="••••••••">
                @if ($errors->updatePassword->get('password_confirmation'))
                    @foreach ($errors->updatePassword->get('password_confirmation') as $error)
                        <p class="form-error">{{ $error }}</p>
                    @endforeach
                @endif
            </div>

            <div class="btn-row">
                <button type="submit" class="btn-primary">
                    <svg width="15" height="15" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    Perbarui Password
                </button>
                @if (session('status') === 'password-updated')
                    <span class="saved-msg"
                        x-data="{ show: true }" x-show="show" x-transition
                        x-init="setTimeout(() => show = false, 2000)">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                        Password diperbarui!
                    </span>
                @endif
            </div>
        </form>
    </div>

    {{-- Danger Zone --}}
    <div class="danger-zone">
        <div class="card-header">
            <div class="card-icon" style="background: #fff0f0;">
                <svg width="20" height="20" fill="none" stroke="#e85555" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <div>
                <div class="card-title" style="color: #e85555;">Hapus Akun</div>
                <div class="card-desc">Setelah dihapus, semua data akan hilang secara permanen.</div>
            </div>
        </div>
        <button class="btn-danger" onclick="document.getElementById('delete-modal').classList.add('active')">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 6h18M19 6l-1 14H6L5 6M9 6V4h6v2"/>
            </svg>
            Hapus Akun Saya
        </button>
    </div>

</div>

{{-- Delete Account Modal --}}
<div class="modal-overlay" id="delete-modal" onclick="if(event.target===this) this.classList.remove('active')">
    <div class="modal-box">
        <div style="width: 52px; height: 52px; border-radius: 14px; background: #fff0f0; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
            <svg width="24" height="24" fill="none" stroke="#e85555" stroke-width="2" viewBox="0 0 24 24">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="modal-title">Hapus akun secara permanen?</div>
        <div class="modal-desc">
            Semua dokumen, data, dan informasi akun Anda akan dihapus selamanya dan tidak dapat dipulihkan kembali.
            Masukkan password Anda untuk mengonfirmasi.
        </div>
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
            <div class="form-group">
                <label class="form-label" for="del-password">Password</label>
                <input class="form-input" id="del-password" name="password"
                    type="password" placeholder="Masukkan password Anda" required>
                @if ($errors->userDeletion->get('password'))
                    @foreach ($errors->userDeletion->get('password') as $error)
                        <p class="form-error">{{ $error }}</p>
                    @endforeach
                @endif
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-secondary"
                    onclick="document.getElementById('delete-modal').classList.remove('active')">
                    Batal
                </button>
                <button type="submit" class="btn-danger" style="background: #e85555; color: white; border-color: #e85555;">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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

    // Auto-open delete modal if there are deletion errors
    @if ($errors->userDeletion->isNotEmpty())
        document.getElementById('delete-modal').classList.add('active');
    @endif
</script>

</body>
</html>