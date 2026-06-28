<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $document->title ?: 'Untitled' }} — WebDocs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f4f6fb; min-height: 100vh; }

        /* ── Navbar ── */
        .navbar {
            background: #fff; border-bottom: 1px solid #e8ecf4;
            position: sticky; top: 0; z-index: 50;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        }
        .navbar-inner {
            max-width: 1300px; margin: 0 auto;
            padding: 0 28px; height: 62px;
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
        }
        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; flex-shrink: 0; }
        .nav-logo-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(79,142,247,0.35);
        }
        .nav-logo-text { font-size: 16px; font-weight: 800; color: #1a1f36; letter-spacing: -0.4px; }
        .nav-badge { font-size: 10px; font-weight: 700; color: #4f8ef7; background: #eef4ff; border-radius: 20px; padding: 2px 8px; }

        /* doc title in navbar */
        .nav-doctitle {
            flex: 1; font-size: 14px; font-weight: 600; color: #4a5068;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            display: flex; align-items: center; gap: 8px;
        }
        .nav-doctitle svg { flex-shrink: 0; color: #b0b8d4; }

        /* typing indicator */
        #typing-indicator {
            font-size: 12px; color: #7c3aed; font-weight: 500;
            display: flex; align-items: center; gap: 6px; flex-shrink: 0;
            opacity: 0; transition: opacity 0.2s;
        }
        #typing-indicator.visible { opacity: 1; }
        .typing-dots { display: flex; gap: 3px; }
        .typing-dots span {
            width: 5px; height: 5px; background: #7c3aed; border-radius: 50%;
            animation: bounce 1s infinite;
        }
        .typing-dots span:nth-child(2) { animation-delay: 0.15s; }
        .typing-dots span:nth-child(3) { animation-delay: 0.3s; }
        @keyframes bounce { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-5px)} }

        /* user btn */
        .user-btn {
            display: flex; align-items: center; gap: 9px;
            background: transparent; border: none; cursor: pointer;
            padding: 6px 10px; border-radius: 12px; transition: background 0.15s;
            position: relative; flex-shrink: 0;
        }
        .user-btn:hover { background: #f4f6fb; }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; color: white;
        }
        .user-name { font-size: 13px; font-weight: 600; color: #1a1f36; }
        .user-sub  { font-size: 11px; color: #9199b8; margin-top: 1px; }
        .user-dropdown {
            display: none; position: absolute; right: 0; top: calc(100% + 8px);
            background: #fff; border: 1px solid #e8ecf4; border-radius: 14px;
            padding: 8px; min-width: 210px;
            box-shadow: 0 12px 36px rgba(30,40,80,0.12); z-index: 100;
        }
        .dropdown-header { padding: 10px 12px 12px; border-bottom: 1px solid #f0f2f8; margin-bottom: 6px; }
        .dropdown-header p:first-child { font-size: 13px; font-weight: 700; color: #1a1f36; }
        .dropdown-header p:last-child  { font-size: 11px; color: #9199b8; margin-top: 3px; }
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

        /* ── Layout ── */
        .page-layout {
            max-width: 1300px; margin: 0 auto;
            padding: 28px 28px 60px;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 24px;
            align-items: start;
        }

        /* ── Sidebar ── */
        .sidebar { display: flex; flex-direction: column; gap: 16px; }

        .side-card {
            background: #fff; border: 1px solid #e8ecf4;
            border-radius: 18px; padding: 20px; overflow: hidden;
        }
        .side-card-header {
            display: flex; align-items: center; gap: 10px; margin-bottom: 16px;
        }
        .side-card-icon {
            width: 34px; height: 34px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .side-card-title { font-size: 13px; font-weight: 700; color: #1a1f36; }
        .side-card-desc  { font-size: 11px; color: #9199b8; margin-top: 2px; }

        /* activity */
        #activities { list-style: none; display: flex; flex-direction: column; gap: 6px; }
        #activities li {
            font-size: 12px; color: #4a5068; padding: 7px 10px;
            background: #f7f9ff; border-radius: 8px;
            border-left: 3px solid #4f8ef7;
        }
        #activities:empty::after {
            content: 'Belum ada aktivitas';
            font-size: 12px; color: #b0b8d4;
        }

        /* online users */
        #online-users { list-style: none; display: flex; flex-direction: column; gap: 6px; }
        #online-users li {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; font-weight: 500; color: #1a1f36;
            padding: 8px 10px; background: #f7f9ff; border-radius: 10px;
        }
        .online-dot {
            width: 8px; height: 8px; border-radius: 50%; background: #22c55e;
            box-shadow: 0 0 0 2px rgba(34,197,94,0.25); flex-shrink: 0;
        }

        /* share link */
        .share-input-wrap { display: flex; gap: 8px; }
        .share-input {
            flex: 1; padding: 9px 13px;
            background: #f7f9ff; border: 1.5px solid #e4e8f2;
            border-radius: 10px; font-size: 12px; color: #4a5068;
            font-family: 'Inter', sans-serif; outline: none;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .btn-copy {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 14px; border-radius: 10px; font-size: 12px; font-weight: 600;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            color: white; border: none; cursor: pointer;
            white-space: nowrap; transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .btn-copy:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-copy.copied { background: linear-gradient(135deg, #22c55e, #16a34a); }

        /* collaborator select */
        .collab-select {
            width: 100%; padding: 9px 13px;
            background: #f7f9ff; border: 1.5px solid #e4e8f2;
            border-radius: 10px; font-size: 13px; color: #1a1f36;
            font-family: 'Inter', sans-serif; outline: none;
            appearance: none; cursor: pointer; transition: border-color 0.2s;
            margin-bottom: 10px;
        }
        .collab-select:focus { border-color: #4f8ef7; box-shadow: 0 0 0 3px rgba(79,142,247,0.12); }
        .btn-add {
            width: 100%; padding: 10px; border-radius: 10px; font-size: 13px; font-weight: 600;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            color: white; border: none; cursor: pointer;
            transition: all 0.2s; font-family: 'Inter', sans-serif;
            display: flex; align-items: center; justify-content: center; gap: 7px;
        }
        .btn-add:hover { opacity: 0.9; transform: translateY(-1px); }

        /* history link */
        .btn-history {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 11px 16px; border-radius: 12px; font-size: 13px; font-weight: 600;
            background: #f4f6fb; color: #4a5068; border: 1.5px solid #e4e8f2;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-history:hover { background: #eef0f8; color: #1a1f36; border-color: #c8d0e8; }

        /* ── Editor area ── */
        .editor-area { display: flex; flex-direction: column; gap: 0; }

        .doc-card {
            background: #fff; border: 1px solid #e8ecf4;
            border-radius: 20px; overflow: hidden;
            box-shadow: 0 2px 16px rgba(79,142,247,0.06);
        }

        .doc-title-input {
            width: 100%; padding: 28px 36px 18px;
            font-size: 32px; font-weight: 800; color: #1a1f36;
            border: none; border-bottom: 1.5px solid #f0f2f8;
            outline: none; font-family: 'Inter', sans-serif;
            background: transparent; letter-spacing: -0.5px;
        }
        .doc-title-input::placeholder { color: #d0d4e8; }

        /* Quill overrides */
        .ql-toolbar.ql-snow {
            border: none !important; border-bottom: 1.5px solid #f0f2f8 !important;
            padding: 10px 20px !important; background: #fafbff;
            display: flex; flex-wrap: wrap; gap: 4px;
        }
        .ql-container.ql-snow {
            border: none !important; font-family: 'Inter', sans-serif;
        }
        #editor { min-height: 480px; padding: 24px 36px; font-size: 15px; line-height: 1.8; color: #2a2f4a; }
        .ql-editor.ql-blank::before { color: #c0c8e0 !important; font-style: normal !important; left: 36px !important; }

        /* font / size css vars */
        .ql-font-arial        { font-family: Arial, sans-serif; }
        .ql-font-calibri      { font-family: Calibri, sans-serif; }
        .ql-font-times-new-roman { font-family: "Times New Roman", serif; }
        .ql-font-courier-new  { font-family: "Courier New", monospace; }
        .ql-font-georgia      { font-family: Georgia, serif; }
        .ql-font-verdana      { font-family: Verdana, sans-serif; }

        .ql-snow .ql-picker.ql-font { width: 160px; }
        .ql-snow .ql-picker.ql-size { width: 65px; }

        .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="arial"]::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="arial"]::before { content:'Arial'; }
        .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="calibri"]::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="calibri"]::before { content:'Calibri'; }
        .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="times-new-roman"]::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="times-new-roman"]::before { content:'Times New Roman'; }
        .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="courier-new"]::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="courier-new"]::before { content:'Courier New'; }
        .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="georgia"]::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="georgia"]::before { content:'Georgia'; }
        .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="verdana"]::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="verdana"]::before { content:'Verdana'; }

        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value="10px"]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="10px"]::before { content:'10'; }
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value="12px"]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="12px"]::before { content:'12'; }
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value="14px"]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="14px"]::before { content:'14'; }
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value="16px"]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="16px"]::before { content:'16'; }
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value="18px"]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="18px"]::before { content:'18'; }
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value="24px"]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="24px"]::before { content:'24'; }
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value="32px"]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item[data-value="32px"]::before { content:'32'; }

        /* save bar */
        .save-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 36px; border-top: 1.5px solid #f0f2f8; background: #fafbff;
            border-radius: 0 0 20px 20px;
        }
        .save-info { font-size: 12px; color: #9199b8; display: flex; align-items: center; gap: 6px; }
        .btn-save {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 28px; border-radius: 12px; font-size: 14px; font-weight: 600;
            background: linear-gradient(135deg, #4f8ef7, #7c3aed);
            color: white; border: none; cursor: pointer;
            box-shadow: 0 4px 14px rgba(79,142,247,0.3);
            transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(79,142,247,0.4); }

        /* success toast */
        .toast {
            position: fixed; bottom: 28px; right: 28px; z-index: 200;
            background: #fff; border: 1px solid #e8ecf4; border-radius: 14px;
            padding: 14px 20px; display: flex; align-items: center; gap: 12px;
            box-shadow: 0 12px 32px rgba(30,40,80,0.14);
            transform: translateY(80px); opacity: 0;
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast-icon { width: 32px; height: 32px; border-radius: 10px; background: #f0fff4; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .toast-title { font-size: 13px; font-weight: 700; color: #1a1f36; }
        .toast-desc  { font-size: 12px; color: #9199b8; }

        @media (max-width: 900px) {
            .page-layout { grid-template-columns: 1fr; }
            .sidebar { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        }
        @media (max-width: 560px) {
            .page-layout { padding: 20px 16px 60px; }
            .sidebar { grid-template-columns: 1fr; }
            .doc-title-input { font-size: 22px; padding: 20px 20px 14px; }
            #editor { padding: 16px 20px; }
            .save-bar { padding: 14px 20px; flex-wrap: wrap; gap: 10px; }
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

        <div class="nav-doctitle">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/>
            </svg>
            {{ $document->title ?: 'Untitled Document' }}
        </div>

        <div id="typing-indicator">
            <div class="typing-dots"><span></span><span></span><span></span></div>
            <span id="typing-name"></span>
        </div>

        <div style="position: relative;">
            <button class="user-btn" onclick="toggleMenu()" id="user-btn">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-sub">Personal workspace</div>
                </div>
                <svg width="13" height="13" fill="none" stroke="#9199b8" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
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
                <a href="{{ route('documents.index') }}" class="dropdown-item">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    Dashboard
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

{{-- Page layout --}}
<div class="page-layout">

    {{-- ── Sidebar ── --}}
    <aside class="sidebar">

        {{-- Aktivitas --}}
        <div class="side-card">
            <div class="side-card-header">
                <div class="side-card-icon" style="background:#eef4ff;">
                    <svg width="16" height="16" fill="none" stroke="#4f8ef7" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                </div>
                <div>
                    <div class="side-card-title">Aktivitas</div>
                    <div class="side-card-desc">Log kejadian real-time</div>
                </div>
            </div>
            <ul id="activities"></ul>
        </div>

        {{-- User Online --}}
        <div class="side-card">
            <div class="side-card-header">
                <div class="side-card-icon" style="background:#f0fff4;">
                    <svg width="16" height="16" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div>
                    <div class="side-card-title">Sedang Online</div>
                    <div class="side-card-desc">Pengguna aktif di dokumen ini</div>
                </div>
            </div>
            <ul id="online-users"></ul>
        </div>

        {{-- Share Link --}}
        <div class="side-card">
            <div class="side-card-header">
                <div class="side-card-icon" style="background:#f0ebff;">
                    <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                    </svg>
                </div>
                <div>
                    <div class="side-card-title">Bagikan Dokumen</div>
                    <div class="side-card-desc">Salin link untuk berbagi</div>
                </div>
            </div>
            <div class="share-input-wrap">
                <input id="share-link" class="share-input" type="text" readonly
                    value="{{ route('documents.shared', $document->share_token) }}">
                <button class="btn-copy" id="copy-btn" onclick="copyLink()">
                    <svg width="13" height="13" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                    </svg>
                    Salin
                </button>
            </div>
        </div>

        {{-- Collaborator --}}
        <div class="side-card">
            <div class="side-card-header">
                <div class="side-card-icon" style="background:#fff4eb;">
                    <svg width="16" height="16" fill="none" stroke="#f59e42" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>
                    </svg>
                </div>
                <div>
                    <div class="side-card-title">Tambah Kolaborator</div>
                    <div class="side-card-desc">Undang pengguna lain</div>
                </div>
            </div>
            <form action="{{ route('documents.invite', $document->id) }}" method="POST">
                @csrf
                <select name="user_id" class="collab-select">
                    @foreach($users as $user)
                        @if($user->id != auth()->id())
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
                <button type="submit" class="btn-add">
                    <svg width="14" height="14" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Tambah
                </button>
            </form>
        </div>

        {{-- History --}}
        <a href="{{ route('documents.history', $document->id) }}" class="btn-history">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 3v5h5"/><path d="M3.05 13A9 9 0 1 0 6 5.3L3 8"/>
            </svg>
            Lihat Version History
        </a>

    </aside>

    {{-- ── Editor ── --}}
    <div class="editor-area">

        @if(session('success'))
            <div style="background:#f0fff4; border:1px solid #bbf7d0; border-radius:12px; padding:12px 16px; margin-bottom:16px; font-size:13px; color:#16a34a; display:flex; align-items:center; gap:8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('documents.update', $document->id) }}" method="POST" onsubmit="saveContent()">
            @csrf
            @method('PUT')

            <div class="doc-card">
                <input id="title" type="text" name="title"
                    value="{{ $document->title }}"
                    placeholder="Judul Dokumen..."
                    class="doc-title-input">

                <div id="editor">{!! $document->content !!}</div>
                <input type="hidden" id="content" name="content">

                <div class="save-bar">
                    <div class="save-info">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                        </svg>
                        Terakhir disimpan: {{ $document->updated_at->diffForHumans() }}
                    </div>
                    <button type="submit" class="btn-save">
                        <svg width="15" height="15" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Dokumen
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>

{{-- Toast --}}
<div class="toast" id="toast">
    <div class="toast-icon">
        <svg width="16" height="16" fill="none" stroke="#22c55e" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
    </div>
    <div>
        <div class="toast-title" id="toast-title">Berhasil!</div>
        <div class="toast-desc" id="toast-desc">Link berhasil disalin.</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
<script>
    // ── Quill setup ──
    const Size = Quill.import('attributors/style/size');
    Size.whitelist = ['10px','12px','14px','16px','18px','24px','32px'];
    Quill.register(Size, true);

    const Font = Quill.import('formats/font');
    Font.whitelist = ['arial','calibri','times-new-roman','courier-new','georgia','verdana'];
    Quill.register(Font, true);

    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Mulai menulis sesuatu yang luar biasa...',
        modules: {
            toolbar: [
                [{ font: ['arial','calibri','times-new-roman','courier-new','georgia','verdana'] }],
                [{ size: ['10px','12px','14px','16px','18px','24px','32px'] }],
                [{ header: [1,2,3,false] }],
                ['bold','italic','underline','strike'],
                [{ color: [] },{ background: [] }],
                [{ align: [] }],
                ['blockquote','code-block'],
                [{ list: 'ordered' },{ list: 'bullet' }],
                ['link','image'],
                ['clean']
            ]
        }
    });

    function saveContent() {
        document.getElementById('content').value = quill.root.innerHTML;
    }

    // ── Copy link ──
    function copyLink() {
        const val = document.getElementById('share-link').value;
        navigator.clipboard.writeText(val);
        const btn = document.getElementById('copy-btn');
        btn.classList.add('copied');
        btn.innerHTML = `<svg width="13" height="13" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg> Disalin!`;
        showToast('Link Disalin!', 'Link dokumen berhasil disalin ke clipboard.');
        setTimeout(() => {
            btn.classList.remove('copied');
            btn.innerHTML = `<svg width="13" height="13" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Salin`;
        }, 2500);
    }

    function showToast(title, desc) {
        const t = document.getElementById('toast');
        document.getElementById('toast-title').textContent = title;
        document.getElementById('toast-desc').textContent  = desc;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 3000);
    }

    // ── User dropdown ──
    function toggleMenu() {
        const m = document.getElementById('user-menu');
        m.style.display = m.style.display === 'block' ? 'none' : 'block';
    }
    document.addEventListener('click', function(e) {
        const btn  = document.getElementById('user-btn');
        const menu = document.getElementById('user-menu');
        if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = 'none';
        }
    });

    // ── Echo / realtime ──
    let typingTimeout;
    let channel;
    let isRemoteUpdate = false;

    document.addEventListener('DOMContentLoaded', function () {
        channel = Echo.join('document.{{ $document->id }}')
            .here((users) => {
                document.getElementById('online-users').innerHTML = users.map(u =>
                    `<li id="user-${u.id}"><span class="online-dot"></span>${u.name}</li>`
                ).join('');
            })
            .joining((user) => {
                document.getElementById('activities').innerHTML =
                    `<li>🟢 ${user.name} masuk</li>` +
                    document.getElementById('activities').innerHTML;
                document.getElementById('online-users').innerHTML +=
                    `<li id="user-${user.id}"><span class="online-dot"></span>${user.name}</li>`;
            })
            .leaving((user) => {
                document.getElementById('activities').innerHTML =
                    `<li>🔴 ${user.name} keluar</li>` +
                    document.getElementById('activities').innerHTML;
                const el = document.getElementById(`user-${user.id}`);
                if (el) el.remove();
            })
            .listen('.document.updated', (e) => {
                if (!quill.hasFocus()) {
                    document.getElementById('title').value = e.document.title;
                }
            })
            .listenForWhisper('editing', (e) => {
                isRemoteUpdate = true;
                document.getElementById('title').value = e.title;
                quill.updateContents(JSON.parse(JSON.stringify(e.delta)), 'silent');
                setTimeout(() => { isRemoteUpdate = false; }, 50);
            })
            .listen('.user.typing', (e) => {
                const indicator = document.getElementById('typing-indicator');
                document.getElementById('typing-name').textContent = e.userName + ' sedang mengetik...';
                indicator.classList.add('visible');
                clearTimeout(typingTimeout);
                typingTimeout = setTimeout(() => indicator.classList.remove('visible'), 2000);
            })
            .listen('.user.activity', (e) => {
                document.getElementById('activities').innerHTML =
                    `<li>${e.message}</li>` +
                    document.getElementById('activities').innerHTML;
            });
    });

    quill.on('text-change', function(delta, oldDelta, source) {
        if (source !== 'user' || isRemoteUpdate) return;
        channel.whisper('editing', {
            title: document.getElementById('title').value,
            delta: delta
        });
        fetch("{{ route('documents.typing', $document->id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        });
    });
</script>

</body>
</html>