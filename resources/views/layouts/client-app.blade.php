<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VetConnect - Pet Care Management')</title>
    @vite(['resources/css/client.css'])
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="header-left">
                <button class="menu-toggle" id="menuToggle" type="button">
                    <span>Menu</span>
                </button>
                <a href="{{ route('client.dashboard') }}" class="logo">
                    <div class="logo-icon">VC</div>
                    <span class="logo-text">VetConnect</span>
                </a>
            </div>

            <div class="header-search">
                <input type="text" placeholder="Search pets, appointments..." class="search-input" disabled>
            </div>

            <div class="header-right">
                <a href="{{ route('profile.edit') }}" class="icon-btn" title="Profile">Profile</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="icon-btn" title="Log out">Log out</button>
                </form>
            </div>
        </div>
    </header>

    <div class="main-container">
        <aside class="sidebar" id="sidebar">
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <p class="nav-section-title">MAIN</p>
                    <ul class="nav-list">
                        <li>
                            <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                                <span>Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="nav-section">
                    <p class="nav-section-title">PET CARE</p>
                    <ul class="nav-list">
                        <li>
                            <a href="{{ route('client.pets.index') }}" class="nav-link {{ request()->routeIs('client.pets.*') ? 'active' : '' }}">
                                <span>My Pets</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('client.appointments.index') }}" class="nav-link {{ request()->routeIs('client.appointments.*') ? 'active' : '' }}">
                                <span>Appointments</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('client.medical-records.index') }}" class="nav-link {{ request()->routeIs('client.medical-records.*') ? 'active' : '' }}">
                                <span>Medical Records</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('client.vaccination-records.index') }}" class="nav-link {{ request()->routeIs('client.vaccination-records.*') ? 'active' : '' }}">
                                <span>Vaccinations</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="nav-section">
                    <p class="nav-section-title">ACCOUNT</p>
                    <ul class="nav-list">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <span>Profile</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <main class="content">
            <div class="content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
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

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(function() { alert.remove(); }, 300);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
