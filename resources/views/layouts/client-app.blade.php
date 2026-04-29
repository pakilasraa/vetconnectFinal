<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VetConnect - Pet Care Management')</title>
    @vite(['resources/css/client.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css"/>
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
                <button class="icon-btn theme-toggle-btn" id="openClientSwitcher" type="button" title="Theme settings">&#9881;</button>
                <a href="{{ route('profile.edit') }}" class="icon-btn" title="Profile">Profile</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="icon-btn" title="Log out">Log out</button>
                </form>
            </div>
        </div>
    </header>

    <div class="client-switcher-overlay" id="clientSwitcherOverlay"></div>
    <aside class="client-switcher" id="clientSwitcher" aria-hidden="true">
        <div class="switcher-header">
            <h3 class="switcher-title">Client Theme</h3>
            <button class="icon-btn" id="closeClientSwitcher" type="button" aria-label="Close">&times;</button>
        </div>
        <div class="switcher-body">
            <div class="switcher-section">
                <p class="switcher-label">Theme Mode</p>
                <div class="switcher-grid">
                    <button class="switcher-option" type="button" data-mode="light">Light</button>
                    <button class="switcher-option" type="button" data-mode="dark">Dark</button>
                </div>
            </div>
            <div class="switcher-section">
                <p class="switcher-label">Primary Color</p>
                <div class="switcher-colors">
                    <button class="swatch-btn" type="button" data-color="teal" style="background:#0d9488" title="Teal"></button>
                    <button class="swatch-btn" type="button" data-color="brown" style="background:#8b5e3c" title="Brown"></button>
                    <button class="swatch-btn" type="button" data-color="blue" style="background:#2563eb" title="Blue"></button>
                    <button class="swatch-btn" type="button" data-color="violet" style="background:#7c3aed" title="Violet"></button>
                    <button class="swatch-btn" type="button" data-color="rose" style="background:#e11d48" title="Rose"></button>
                </div>
            </div>
            <div class="switcher-section">
                <button class="btn btn-outline" type="button" id="resetClientTheme">Reset Theme</button>
            </div>
        </div>
    </aside>

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
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function () {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const switcher = document.getElementById('clientSwitcher');
            const switcherOverlay = document.getElementById('clientSwitcherOverlay');
            const openSwitcher = document.getElementById('openClientSwitcher');
            const closeSwitcher = document.getElementById('closeClientSwitcher');
            const modeButtons = Array.from(document.querySelectorAll('[data-mode]'));
            const colorButtons = Array.from(document.querySelectorAll('[data-color]'));
            const resetThemeBtn = document.getElementById('resetClientTheme');
            const body = document.body;
            const root = document.documentElement;

            const palettes = {
                teal: { primary: '#0d9488', hover: '#0f766e', soft: 'rgba(13, 148, 136, 0.12)' },
                brown: { primary: '#8b5e3c', hover: '#6f482c', soft: 'rgba(139, 94, 60, 0.16)' },
                blue: { primary: '#2563eb', hover: '#1d4ed8', soft: 'rgba(37, 99, 235, 0.14)' },
                violet: { primary: '#7c3aed', hover: '#6d28d9', soft: 'rgba(124, 58, 237, 0.14)' },
                rose: { primary: '#e11d48', hover: '#be123c', soft: 'rgba(225, 29, 72, 0.14)' }
            };

            const themeStorageKey = 'clientThemeV1';

            function getStoredTheme() {
                try {
                    return JSON.parse(localStorage.getItem(themeStorageKey) || '{}');
                } catch (e) {
                    return {};
                }
            }

            function saveTheme(nextTheme) {
                localStorage.setItem(themeStorageKey, JSON.stringify(nextTheme));
            }

            function applyTheme(theme) {
                const mode = theme.mode || 'light';
                const color = theme.color || 'teal';
                const palette = palettes[color] || palettes.teal;

                body.classList.toggle('client-dark', mode === 'dark');
                root.style.setProperty('--client-primary', palette.primary);
                root.style.setProperty('--client-primary-hover', palette.hover);
                root.style.setProperty('--client-primary-soft', palette.soft);

                modeButtons.forEach((btn) => btn.classList.toggle('active', btn.dataset.mode === mode));
                colorButtons.forEach((btn) => btn.classList.toggle('active', btn.dataset.color === color));
            }

            function updateTheme(patch) {
                const merged = { ...getStoredTheme(), ...patch };
                saveTheme(merged);
                applyTheme(merged);
            }

            function resetTheme() {
                localStorage.removeItem(themeStorageKey);
                applyTheme({ mode: 'light', color: 'teal' });
            }

            function toggleSwitcher(open) {
                switcher.classList.toggle('active', open);
                switcherOverlay.classList.toggle('active', open);
                switcher.setAttribute('aria-hidden', open ? 'false' : 'true');
            }

            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
            openSwitcher.addEventListener('click', function () { toggleSwitcher(true); });
            closeSwitcher.addEventListener('click', function () { toggleSwitcher(false); });
            switcherOverlay.addEventListener('click', function () { toggleSwitcher(false); });
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') toggleSwitcher(false);
            });

            modeButtons.forEach((btn) => {
                btn.addEventListener('click', function () {
                    updateTheme({ mode: btn.dataset.mode });
                });
            });
            colorButtons.forEach((btn) => {
                btn.addEventListener('click', function () {
                    updateTheme({ color: btn.dataset.color });
                });
            });
            resetThemeBtn.addEventListener('click', resetTheme);

            applyTheme(getStoredTheme());

            if (!window.Swal) return;

            const swalAnim = {
                showClass: {
                    popup: 'animate__animated animate__fadeInUp animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutDown animate__faster'
                }
            };

            function buildThemeOptions() {
                const styles = getComputedStyle(root);
                const primary = (styles.getPropertyValue('--client-primary') || '#0d9488').trim();
                const isDark = body.classList.contains('client-dark');
                return {
                    confirmButtonColor: primary,
                    cancelButtonColor: isDark ? '#475569' : '#64748b',
                    background: isDark ? '#111827' : '#ffffff',
                    color: isDark ? '#e5e7eb' : '#111827'
                };
            }

            function themedSwal(options) {
                return Swal.fire({
                    ...swalAnim,
                    ...buildThemeOptions(),
                    ...options
                });
            }

            const successMessage = @json(session('success'));
            const errorMessage = @json(session('error'));
            const errorList = @json($errors->all());

            if (successMessage) {
                themedSwal({
                    icon: 'success',
                    title: 'Success',
                    text: successMessage,
                    confirmButtonText: 'OK'
                });
            } else if (errorMessage) {
                themedSwal({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    confirmButtonText: 'OK'
                });
            } else if (Array.isArray(errorList) && errorList.length > 0) {
                themedSwal({
                    icon: 'error',
                    title: 'Please check your input',
                    html: '<ul style="text-align:left;margin:0;padding-left:1.1rem;">' + errorList.map((msg) => `<li>${msg}</li>`).join('') + '</ul>',
                    confirmButtonText: 'OK'
                });
            }

            function getConfirmMessageFromAttr(attrValue) {
                if (!attrValue) return 'Are you sure?';
                const match = attrValue.match(/confirm\((['"`])([\s\S]*?)\1\)/);
                return match && match[2] ? match[2] : 'Are you sure?';
            }

            async function runConfirm(message) {
                const result = await themedSwal({
                    title: 'Please confirm',
                    text: message || 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, continue',
                    cancelButtonText: 'Cancel'
                });

                return result.isConfirmed;
            }

            document.addEventListener('click', async function (event) {
                const trigger = event.target.closest('[onclick*="confirm("]');
                if (!trigger) return;

                event.preventDefault();
                event.stopImmediatePropagation();

                const message = getConfirmMessageFromAttr(trigger.getAttribute('onclick'));
                const confirmed = await runConfirm(message);
                if (!confirmed) return;

                const form = trigger.closest('form');
                if (form) {
                    form.submit();
                    return;
                }

                if (trigger.tagName === 'A' && trigger.href) {
                    window.location.href = trigger.href;
                }
            }, true);

            document.addEventListener('submit', async function (event) {
                const form = event.target;
                if (!(form instanceof HTMLFormElement)) return;
                const onsubmitAttr = form.getAttribute('onsubmit');
                if (!onsubmitAttr || !onsubmitAttr.includes('confirm(')) return;

                event.preventDefault();
                event.stopImmediatePropagation();

                const message = getConfirmMessageFromAttr(onsubmitAttr);
                const confirmed = await runConfirm(message);
                if (confirmed) form.submit();
            }, true);
        })();
    </script>

    @stack('scripts')
</body>
</html>
