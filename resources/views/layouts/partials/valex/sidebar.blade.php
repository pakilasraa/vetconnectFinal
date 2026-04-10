<!-- Start::app-sidebar -->
<aside class="app-sidebar" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ url('/') }}" class="header-logo">
            @include('layouts.partials.valex.logo', ['class' => 'desktop-logo'])
            @include('layouts.partials.valex.logo', ['class' => 'toggle-logo'])
            @include('layouts.partials.valex.logo', ['class' => 'desktop-dark'])
            @include('layouts.partials.valex.logo', ['class' => 'toggle-dark'])
            @include('layouts.partials.valex.logo', ['class' => 'desktop-white'])
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                    height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg></div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->

                <li class="slide">
                    <a href="{{ route('dashboard') }}" class="side-menu__item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="side-menu__icon fe fe-airplay"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Pet Care</span></li>
                <!-- End::slide__category -->

                <li class="slide">
                    <a href="{{ route('pets.index') }}" class="side-menu__item {{ request()->is('pets*') ? 'active' : '' }}">
                        <i class="side-menu__icon fe fe-github"></i>
                        <span class="side-menu__label">Pets</span>
                    </a>
                </li>

                <li class="slide">
                    <a href="{{ route('appointments.index') }}" class="side-menu__item {{ request()->is('appointments*') ? 'active' : '' }}">
                        <i class="side-menu__icon fe fe-calendar"></i>
                        <span class="side-menu__label">Appointments</span>
                    </a>
                </li>

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item {{ (request()->is('medical-records*') || request()->is('vaccination-records*')) ? 'active' : '' }}">
                        <i class="side-menu__icon fe fe-file-text"></i>
                        <span class="side-menu__label">Medical Records</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide">
                            <a href="{{ route('medical-records.index') }}" class="side-menu__item {{ request()->is('medical-records*') ? 'active' : '' }}">Consultations</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('vaccination-records.index') }}" class="side-menu__item {{ request()->is('vaccination-records*') ? 'active' : '' }}">Vaccinations</a>
                        </li>
                    </ul>
                </li>

                <!-- Start::slide__category -->
                @if (auth()->user()->role !== 'owner')
                    <li class="slide__category"><span class="category-name">Management</span></li>
                    <!-- End::slide__category -->

                    <li class="slide">
                        <a href="{{ route('users.index') }}"
                            class="side-menu__item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                            <i class="side-menu__icon fe fe-users"></i>
                            <span class="side-menu__label">Users Management</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a href="{{ route('activity-logs.index') }}"
                            class="side-menu__item {{ request()->routeIs('activity-logs.index') ? 'active' : '' }}">
                            <i class="side-menu__icon fe fe-activity"></i>
                            <span class="side-menu__label">Activity Logs</span>
                        </a>
                    </li>
                @endif

                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Account</span></li>
                <!-- End::slide__category -->

                <li class="slide">
                    <a href="{{ route('profile.edit') }}" class="side-menu__item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="side-menu__icon fe fe-user"></i>
                        <span class="side-menu__label">Profile</span>
                    </a>
                </li>

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                    height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->
