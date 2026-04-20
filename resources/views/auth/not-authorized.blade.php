<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Not authorized — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 text-center">
        <p class="text-sm font-medium text-amber-600 dark:text-amber-400 uppercase tracking-wide">Access denied</p>
        <h1 class="mt-2 text-2xl font-semibold text-gray-900 dark:text-white">You are not authorized to view this page.</h1>
        <p class="mt-3 text-gray-600 dark:text-gray-300 text-sm">
            This area is restricted. Sign in with an account that has the correct role, or return to your dashboard.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">Admin dashboard</a>
                @endif
                @if(auth()->user()->isPetOwner())
                    <a href="{{ route('client.dashboard') }}" class="inline-flex justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-500">My dashboard</a>
                @endif
            @endauth
            <a href="{{ url('/') }}" class="inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">Home</a>
        </div>
    </div>
</body>
</html>
