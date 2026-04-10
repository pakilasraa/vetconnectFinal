@php
    $isWhiteText = str_contains($class, 'white-text');
@endphp

<div class="flex items-center gap-2 logo-container {{ $class }}">
    <div class="logo-icon bg-primary rounded-lg p-1.5 flex items-center justify-center shadow-sm">
        <i class="fa fa-paw text-white text-xl"></i>
    </div>
    <div class="logo-text font-bold text-xl tracking-tight">
        <span class="{{ $isWhiteText ? '!text-white' : 'text-primary' }} dark:text-white">Vet</span><span class="{{ $isWhiteText ? '!text-white' : 'text-secondary' }} opacity-80 dark:text-gray-300">Connect</span>
    </div>
</div>

<style>
    .logo-container {
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }
    .logo-icon i {
        transform: rotate(-15deg);
        transition: transform 0.3s ease;
    }
    .logo-container:hover .logo-icon i {
        transform: rotate(0deg) scale(1.1);
    }
    .logo-text {
        font-family: 'Outfit', 'Inter', sans-serif;
    }
    
    /* Adapt to Valex template classes */
    /* By default, show everything. Specific Valex classes will hide parts if needed. */
    .logo-text {
        display: inline-block;
    }
    
    /* When in a 'toggle-logo' or 'toggle-dark' state in some templates, hide text if desired */
    /* However, for VetConnect, we usually want the logo text visible unless it's a very tiny sidebar */
    
    .desktop-dark .logo-text span,
    .desktop-white .logo-text span,
    .toggle-dark .logo-text span,
    .toggle-white .logo-text span {
        color: white !important;
    }

    /* Ensure only one logo shows in dashboard when sidebar is toggled */
    /* Desktop sidebar usually shows 'desktop-logo' or 'desktop-white' */
    /* Collapsed sidebar shows 'toggle-logo' or 'toggle-dark' */
    
    /* Specific overrides for dashboard layout state to prevent duplication */
    [data-nav-layout="vertical"][data-vertical-style="closed"] .app-sidebar .logo-text,
    [data-nav-layout="vertical"][data-vertical-style="icontext-menu"] .app-sidebar .logo-text,
    [data-nav-layout="vertical"][data-vertical-style="icon-overlay"] .app-sidebar .logo-text,
    [data-nav-layout="vertical"][data-vertical-style="detached"] .app-sidebar .logo-text,
    [data-toggled="close-menu-close"] .app-sidebar .logo-text,
    [data-toggled="icon-text-close"] .app-sidebar .logo-text,
    [data-toggled="icon-overlay-close"] .app-sidebar .logo-text,
    [data-toggled="detached-close"] .app-sidebar .logo-text,
    [data-toggled="menu-click-closed"] .app-sidebar .logo-text,
    [data-toggled="menu-hover-closed"] .app-sidebar .logo-text,
    [data-toggled="icon-click-closed"] .app-sidebar .logo-text,
    [data-toggled="icon-hover-closed"] .app-sidebar .logo-text {
        display: none !important;
    }

    /* Center logo icon when text is hidden in collapsed view */
    [data-toggled] .main-sidebar-header .logo-container {
        justify-content: center;
        width: 100%;
        gap: 0;
    }
</style>
