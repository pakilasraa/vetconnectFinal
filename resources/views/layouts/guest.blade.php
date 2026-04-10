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
            justify-content: center;
            text-decoration: none;
            margin-bottom: 1.75rem;
        }
        .auth-footer-text {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 1.5rem;
            text-align: center;
        }
        /* Fix: ensure all text in auth card is pure black and readable */
        .auth-card-box label,
        .auth-card-box p,
        .auth-card-box h4,
        .auth-card-box h5,
        .auth-card-box span:not(.ti-btn *) {
            color: #000000 !important;
        }
        .auth-card-box .form-control {
            color: #000000 !important;
            background-color: #ffffff !important;
            border-color: #d1d5db !important;
        }
        .auth-card-box .form-control::placeholder {
            color: #9ca3af !important;
        }
        /* Fix logo text on light background */
        .auth-logo-link .logo-text span {
            opacity: 1 !important;
        }
        .auth-logo-link .logo-text .text-secondary {
            color: #4f46e5 !important;
        }
        /* Subtext color fix - override any gray inline styles */
        .auth-card-box p[style*="color:#6b7280"],
        .auth-card-box p[style*="color: #6b7280"],
        .auth-card-box p[style*="color:#374151"],
        .auth-card-box p[style*="color: #374151"] {
            color: #000000 !important;
        }
    </style>
</head>
<body>

<div class="auth-page-bg">

    <div class="auth-card-wrapper">
        {{-- Logo --}}
        <div style="text-align:center;">
            <a href="{{ url('/') }}" class="auth-logo-link">
                @include('layouts.partials.valex.logo', ['class' => ''])
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
