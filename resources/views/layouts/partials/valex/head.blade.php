<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> @yield('title', config('app.name', 'Laravel')) </title>
<meta name="description" content="VetConnectV2 - Veterinary Management System">

<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('backend/assets/images/brand-logos/favicon.ico') }}">

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
