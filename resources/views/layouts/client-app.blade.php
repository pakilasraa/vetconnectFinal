<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VetConnect - Pet Care Management')</title>
    <link id="theme-favicon" rel="icon" type="image/svg+xml" href="{{ asset('backend/assets/iconfonts/fontawesome/svgs/solid/paw.svg') }}">
    <link id="theme-favicon-shortcut" rel="shortcut icon" href="{{ asset('backend/assets/iconfonts/fontawesome/svgs/solid/paw.svg') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/iconfonts/fontawesome/css/all.css') }}">
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
                    <div class="logo-icon">
                        <i class="fa-solid fa-paw" aria-hidden="true"></i>
                    </div>
                    <span class="logo-text">
                        <span class="logo-text-primary">Vet</span><span class="logo-text-secondary">Connect</span>
                    </span>
                </a>
            </div>

            <div class="header-search">
                <input type="text" placeholder="Search pets, appointments..." class="search-input" disabled>
            </div>

            <div class="header-right">
                <button class="icon-btn theme-toggle-btn" id="openClientSwitcher" type="button" title="Theme settings">&#9881;</button>
                <a href="{{ route('profile.edit') }}" class="icon-btn profile-link-btn" title="Profile">
                    <img src="{{ auth()->user()->photo_url }}" alt="Profile" class="profile-link-avatar">
                    <span>Profile</span>
                </a>
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
                <p class="switcher-label">Custom Primary Color</p>
                <div class="switcher-color-picker">
                    <input class="color-picker-input" id="customClientColor" type="color" value="#0d9488" aria-label="Choose custom primary color">
                    <span class="color-picker-help">Pick any color to use as your theme primary.</span>
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
            const customColorInput = document.getElementById('customClientColor');
            const resetThemeBtn = document.getElementById('resetClientTheme');
            const body = document.body;
            const root = document.documentElement;
            const faviconLink = document.getElementById('theme-favicon');
            const faviconShortcutLink = document.getElementById('theme-favicon-shortcut');

            const palettes = {
                teal: { primary: '#0d9488', hover: '#0f766e', soft: 'rgba(13, 148, 136, 0.12)' },
                brown: { primary: '#8b5e3c', hover: '#6f482c', soft: 'rgba(139, 94, 60, 0.16)' },
                blue: { primary: '#2563eb', hover: '#1d4ed8', soft: 'rgba(37, 99, 235, 0.14)' },
                violet: { primary: '#7c3aed', hover: '#6d28d9', soft: 'rgba(124, 58, 237, 0.14)' },
                rose: { primary: '#e11d48', hover: '#be123c', soft: 'rgba(225, 29, 72, 0.14)' }
            };

            const themeStorageKey = 'clientThemeV1';

            function normalizeHexColor(hex) {
                if (typeof hex !== 'string') return null;
                const value = hex.trim().toLowerCase();
                return /^#[0-9a-f]{6}$/.test(value) ? value : null;
            }

            function hexToRgb(hex) {
                const normalized = normalizeHexColor(hex);
                if (!normalized) return null;
                const raw = normalized.slice(1);
                return {
                    r: parseInt(raw.slice(0, 2), 16),
                    g: parseInt(raw.slice(2, 4), 16),
                    b: parseInt(raw.slice(4, 6), 16)
                };
            }

            function rgbToHex(rgb) {
                const toHex = (v) => Math.max(0, Math.min(255, v)).toString(16).padStart(2, '0');
                return `#${toHex(rgb.r)}${toHex(rgb.g)}${toHex(rgb.b)}`;
            }

            function darkenHex(hex, factor) {
                const rgb = hexToRgb(hex);
                if (!rgb) return '#0f766e';
                return rgbToHex({
                    r: Math.round(rgb.r * factor),
                    g: Math.round(rgb.g * factor),
                    b: Math.round(rgb.b * factor)
                });
            }

            function toSoftRgba(hex, alpha) {
                const rgb = hexToRgb(hex);
                if (!rgb) return 'rgba(13, 148, 136, 0.12)';
                return `rgba(${rgb.r}, ${rgb.g}, ${rgb.b}, ${alpha})`;
            }

            function buildCustomPalette(hex) {
                const color = normalizeHexColor(hex) || '#0d9488';
                return {
                    primary: color,
                    hover: darkenHex(color, 0.82),
                    soft: toSoftRgba(color, 0.14)
                };
            }

            function buildPawFaviconDataUri(hexColor) {
                const color = normalizeHexColor(hexColor) || '#0d9488';
                const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="${color}" d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>`;
                return `data:image/svg+xml,${encodeURIComponent(svg)}`;
            }

            function applyFaviconTheme(hexColor) {
                const faviconDataUri = buildPawFaviconDataUri(hexColor);
                if (faviconLink) faviconLink.setAttribute('href', faviconDataUri);
                if (faviconShortcutLink) faviconShortcutLink.setAttribute('href', faviconDataUri);
            }

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
                const customColor = normalizeHexColor(theme.customColor);
                const isCustomColor = color === 'custom' && !!customColor;
                const palette = isCustomColor
                    ? buildCustomPalette(customColor)
                    : (palettes[color] || palettes.teal);

                body.classList.toggle('client-dark', mode === 'dark');
                root.style.setProperty('--client-primary', palette.primary);
                root.style.setProperty('--client-primary-hover', palette.hover);
                root.style.setProperty('--client-primary-soft', palette.soft);
                applyFaviconTheme(palette.primary);

                modeButtons.forEach((btn) => btn.classList.toggle('active', btn.dataset.mode === mode));
                colorButtons.forEach((btn) => btn.classList.toggle('active', btn.dataset.color === color && !isCustomColor));

                if (customColorInput) {
                    customColorInput.value = customColor || '#0d9488';
                    customColorInput.classList.toggle('active', isCustomColor);
                }
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
            if (customColorInput) {
                customColorInput.addEventListener('input', function () {
                    const hex = normalizeHexColor(customColorInput.value);
                    if (!hex) return;
                    updateTheme({ color: 'custom', customColor: hex });
                });
            }
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
