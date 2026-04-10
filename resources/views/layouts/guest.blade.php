<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="light">
<head>
    {{-- Force light mode BEFORE Valex main.js can apply dark theme from localStorage --}}
    <script>document.documentElement.className = 'light';</script>
    @include('layouts.partials.valex.head')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-page-bg {
            min-height: 100vh;
            background: #f3f4f6;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .auth-card-wrapper {
            width: 100%;
            max-width: 440px;
        }
        .auth-card-box {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 4px 32px rgba(0,0,0,0.08);
            padding: 2.25rem;
        }
        .auth-logo-link {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            margin-bottom: 1.75rem;
        }
        .auth-logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366f1, #10b981);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-logo-text {
            font-size: 1.3rem;
            font-weight: 700;
            color: #111827;
            letter-spacing: 0.01em;
        }
        .auth-footer-text {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 1.5rem;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="auth-page-bg">

    <div class="auth-card-wrapper">
        {{-- Logo --}}
        <div style="text-align:center;">
            <a href="{{ url('/') }}" class="auth-logo-link" style="justify-content:center;">
                <div class="auth-logo-icon">
                    <i class="ri-heart-pulse-line" style="color:#fff; font-size:1.2rem;"></i>
                </div>
                <span class="auth-logo-text">VetConnect</span>
            </a>
        </div>

        {{-- Auth Card --}}
        <div class="auth-card-box">
            {{ $slot }}
        </div>

        <p class="auth-footer-text">&copy; {{ date('Y') }} VetConnect. All rights reserved.</p>
    </div>

</div>

@include('layouts.partials.valex.scripts')
</body>
</html>
