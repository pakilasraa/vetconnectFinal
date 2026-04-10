<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="light">
<head>
    {{-- Force light mode BEFORE Valex main.js can apply dark theme from localStorage --}}
    <script>document.documentElement.className = 'light';</script>
    @include('layouts.partials.valex.head')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-bg-panel {
            background: linear-gradient(135deg, #1a1d3a 0%, #0f2027 40%, #1a3a2a 100%);
            position: relative;
            overflow: hidden;
        }
        .auth-bg-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 30% 60%, rgba(99, 102, 241, 0.25) 0%, transparent 60%),
                        radial-gradient(ellipse at 70% 30%, rgba(16, 185, 129, 0.2) 0%, transparent 60%);
        }
        .auth-bg-panel .overlay-dots {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        .auth-card {
            transition: box-shadow 0.3s ease;
        }
        .auth-card:hover {
            box-shadow: 0 20px 60px rgba(0,0,0,0.12) !important;
        }
        body.dark .auth-form-side {
            background-color: #0e1726 !important;
        }
        .auth-feature-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 999px;
            padding: 0.4rem 1rem;
            color: rgba(255,255,255,0.85);
            font-size: 0.78rem;
            font-weight: 500;
            backdrop-filter: blur(8px);
        }
        .floating-card {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            backdrop-filter: blur(12px);
            padding: 1rem 1.25rem;
        }
    </style>
</head>
<body class="bg-[#f3f4f6] dark:bg-[#0e1726]" id="auth-body">

<div class="flex min-h-screen">

    {{-- LEFT PANEL: Illustration & Branding --}}
    <div class="auth-bg-panel hidden lg:flex lg:w-[55%] flex-col items-center justify-center p-12 relative">
        <div class="overlay-dots"></div>
        
        {{-- Content over the bg --}}
        <div class="relative z-10 text-center max-w-md">
            
            {{-- Logo --}}
            <div class="mb-8">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-emerald-500 flex items-center justify-center shadow-lg">
                        <i class="ri-heart-pulse-line text-white text-xl"></i>
                    </div>
                    <span class="text-white text-2xl font-bold tracking-wide">VetConnect</span>
                </a>
            </div>

            {{-- Main Illustration --}}
            <div class="mb-8 relative">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f2027]/80 to-transparent rounded-2xl z-10"></div>
                <img 
                    src="{{ asset('backend/assets/images/authentication/vet-auth-bg.png') }}"
                    alt="VetConnect veterinary illustration"
                    class="w-full max-w-sm mx-auto rounded-2xl shadow-2xl object-cover"
                    style="max-height: 320px; object-fit: cover;"
                >
            </div>

            {{-- Tagline --}}
            <h2 class="text-white text-2xl font-bold mb-3">Your Complete Clinic Solution</h2>
            <p class="text-white/70 text-[0.9rem] mb-8 leading-relaxed">Manage pets, appointments, and medical records seamlessly — all in one place.</p>

            {{-- Feature Badges --}}
            <div class="flex flex-wrap gap-2 justify-center mb-8">
                <span class="auth-feature-badge"><i class="ri-calendar-check-line"></i> Appointments</span>
                <span class="auth-feature-badge"><i class="ri-file-list-3-line"></i> Medical Records</span>
                <span class="auth-feature-badge"><i class="ri-syringe-line"></i> Vaccinations</span>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-3 text-center">
                <div class="floating-card">
                    <p class="text-white font-bold text-lg mb-0">500+</p>
                    <p class="text-white/60 text-[0.7rem] mb-0">Clinics</p>
                </div>
                <div class="floating-card">
                    <p class="text-white font-bold text-lg mb-0">50K+</p>
                    <p class="text-white/60 text-[0.7rem] mb-0">Pets</p>
                </div>
                <div class="floating-card">
                    <p class="text-white font-bold text-lg mb-0">4.9★</p>
                    <p class="text-white/60 text-[0.7rem] mb-0">Rating</p>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL: Form (always light) --}}
    <div class="auth-form-side w-full lg:w-[45%] flex flex-col items-center justify-center px-6 py-10" style="background-color: #f3f4f6;">
        
        {{-- Mobile Logo (visible only on small screens) --}}
        <div class="mb-6 lg:hidden text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-emerald-500 flex items-center justify-center">
                    <i class="ri-heart-pulse-line text-white text-sm"></i>
                </div>
                <span class="text-gray-800 dark:text-white text-xl font-bold">VetConnect</span>
            </a>
        </div>

        <div class="w-full max-w-md auth-card">
            <div style="background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 4px 24px rgba(0,0,0,0.08);">
                <div style="padding: 2rem;">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <div class="text-center mt-6">
            <p class="text-textmuted text-[0.75rem] mb-0">&copy; {{ date('Y') }} VetConnect. All rights reserved.</p>
        </div>
    </div>

</div>



@include('layouts.partials.valex.scripts')
</body>
</html>
