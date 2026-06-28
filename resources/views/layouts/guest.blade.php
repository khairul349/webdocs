<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>WebDocs</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }

            .guest-navbar {
                background: #ffffff;
                border-bottom: 1px solid #e8ecf4;
                position: sticky; top: 0; z-index: 50;
                box-shadow: 0 1px 8px rgba(0,0,0,0.06);
            }
            .guest-navbar-inner {
                max-width: 1200px; margin: 0 auto;
                padding: 0 28px; height: 62px;
                display: flex; align-items: center; justify-content: center;
            }
            .guest-nav-logo {
                display: flex; align-items: center; gap: 10px; text-decoration: none;
            }
            .guest-nav-logo-icon {
                width: 36px; height: 36px; border-radius: 10px;
                background: linear-gradient(135deg, #4f8ef7, #7c3aed);
                display: flex; align-items: center; justify-content: center;
                box-shadow: 0 4px 12px rgba(79,142,247,0.35);
                flex-shrink: 0;
            }
            .guest-nav-logo-text {
                font-size: 16px; font-weight: 800; color: #1a1f36;
                letter-spacing: -0.4px;
            }
            .guest-nav-badge {
                font-size: 10px; font-weight: 700; color: #4f8ef7;
                background: #eef4ff; border-radius: 20px;
                padding: 2px 8px; letter-spacing: 0.5px;
            }

            .guest-card {
                background: #fff; border: 1px solid #e8ecf4; border-radius: 20px;
                box-shadow: 0 20px 60px rgba(30,40,80,0.10);
            }
        </style>
    </head>
    <body class="antialiased" style="background: #f4f6fb;">

        <nav class="guest-navbar">
            <div class="guest-navbar-inner">
                <a href="{{ url('/') }}" class="guest-nav-logo">
                    <div class="guest-nav-logo-icon">
                        <svg width="18" height="18" fill="white" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zm0 2.5L18.5 9H14z"/>
                        </svg>
                    </div>
                    <span class="guest-nav-logo-text">WebDocs</span>
                    <span class="guest-nav-badge">BETA</span>
                </a>
            </div>
        </nav>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-12 sm:pt-16 pb-12 px-4" style="background: #f4f6fb;">
            <div class="w-full sm:max-w-md px-8 py-8 guest-card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>