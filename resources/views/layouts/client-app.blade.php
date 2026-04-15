<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VetConnect - Pet Care Management')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="header-left">
                <button class="menu-toggle" id="menuToggle">
                    <span>☰</span>
                </button>
                <a href="{{ route('dashboard') }}" class="logo">
                    <div class="logo-icon">🐾</div>
                    <span class="logo-text">VetConnect</span>
                </a>
            </div>

            <div class="header-search">
                <input type="text" placeholder="Search pets, appointments..." class="search-input">
            </div>

            <div class="header-right">
                <button class="icon-btn notification-btn">
                    🔔
                    <span class="badge"></span>
                </button>
                <a href="{{ route('profile.index') }}" class="icon-btn">
                    👤
                </a>
            </div>
        </div>
    </header>

    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <p class="nav-section-title">MAIN</p>
                    <ul class="nav-list">
                        <li>
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                                📅 <span>Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="nav-section">
                    <p class="nav-section-title">PET CARE</p>
                    <ul class="nav-list">
                        <li>
                            <a href="{{ route('pets.index') }}" class="nav-link {{ request()->routeIs('pets*') ? 'active' : '' }}">
                                ❤️ <span>My Pets</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('appointments.index') }}" class="nav-link {{ request()->routeIs('appointments*') ? 'active' : '' }}">
                                📅 <span>Appointments</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('medical-records.index') }}" class="nav-link {{ request()->routeIs('medical-records*') ? 'active' : '' }}">
                                📄 <span>Medical Records</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="nav-section">
                    <p class="nav-section-title">ACCOUNT</p>
                    <ul class="nav-list">
                        <li>
                            <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
                                👤 <span>Profile</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <div class="content-wrapper">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
