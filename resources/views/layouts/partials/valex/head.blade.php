<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> @yield('title', config('app.name', 'Laravel')) </title>
<meta name="description" content="VetConnectV2 - Veterinary Management System">

<!-- Favicon -->
<link id="theme-favicon" rel="icon" type="image/svg+xml" href="{{ asset('backend/assets/iconfonts/fontawesome/svgs/solid/paw.svg') }}">
<link id="theme-favicon-shortcut" rel="shortcut icon" href="{{ asset('backend/assets/iconfonts/fontawesome/svgs/solid/paw.svg') }}">

<script>
    (function () {
        function normalizeRgb(rgbText) {
            if (typeof rgbText !== 'string') return null;
            const clean = rgbText.trim().replace(/\s+/g, '');
            const match = clean.match(/^(\d{1,3}),(\d{1,3}),(\d{1,3})$/);
            if (!match) return null;
            const values = match.slice(1).map(Number);
            if (values.some((value) => Number.isNaN(value) || value < 0 || value > 255)) return null;
            return values;
        }

        function rgbToHex(rgbArray) {
            return `#${rgbArray.map((value) => value.toString(16).padStart(2, '0')).join('')}`;
        }

        function buildPawFaviconDataUri(colorHex) {
            const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="${colorHex}" d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5v1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3v-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z"/></svg>`;
            return `data:image/svg+xml,${encodeURIComponent(svg)}`;
        }

        function getAdminPrimaryColor() {
            const fromStorage = normalizeRgb(localStorage.getItem('primaryRGB') || '');
            if (fromStorage) return rgbToHex(fromStorage);

            const computed = getComputedStyle(document.documentElement).getPropertyValue('--primary-rgb');
            const fromCssVar = normalizeRgb(computed || '');
            if (fromCssVar) return rgbToHex(fromCssVar);

            return '#3a5892';
        }

        function applyThemeFavicon() {
            const colorHex = getAdminPrimaryColor();
            const href = buildPawFaviconDataUri(colorHex);
            const icon = document.getElementById('theme-favicon');
            const shortcut = document.getElementById('theme-favicon-shortcut');
            if (icon) icon.setAttribute('href', href);
            if (shortcut) shortcut.setAttribute('href', href);
        }

        applyThemeFavicon();

        const html = document.documentElement;
        const observer = new MutationObserver(applyThemeFavicon);
        observer.observe(html, { attributes: true, attributeFilter: ['style'] });

        window.addEventListener('storage', function (event) {
            if (event.key === 'primaryRGB') applyThemeFavicon();
        });
    })();
</script>

<!-- Main JS -->
<script src="{{ asset('backend/assets/js/main.js') }}"></script>

<!-- Style Css -->
<link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">

<!-- Simplebar Css -->
<link rel="stylesheet" href="{{ asset('backend/assets/libs/simplebar/simplebar.min.css') }}">

<!-- Color Picker Css -->
<link rel="stylesheet" href="{{ asset('backend/assets/libs/@simonwep/pickr/themes/nano.min.css') }}">

<!-- Icon fonts -->
<link rel="stylesheet" href="{{ asset('backend/assets/iconfonts/boxicons/css/boxicons.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/iconfonts/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/iconfonts/feather/feather.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/iconfonts/line-awesome/line-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/iconfonts/materialdesignicons/materialdesignicons.css') }}">

<!-- Jsvector Maps -->
<link rel="stylesheet" href="{{ asset('backend/assets/libs/jsvectormap/css/jsvectormap.min.css') }}">

@yield('styles')
