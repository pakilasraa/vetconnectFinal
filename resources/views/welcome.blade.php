<!DOCTYPE html>
<html lang="en" class="h-full" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click"
    data-menu-position="fixed">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> VetConnect - Veterinary Clinic Management </title>
    <meta name="description"
        content="VetConnect is a pre-designed web page for an admin dashboard. Optimizing it for SEO includes using meta descriptions and ensuring it's responsive and fast-loading.">
    <meta name="keywords"
        content="dashboard,admin dashboard,template dashboard,html,html dashboard,admin dashboard template,admin template,tailwind ui,admin panel,html and css,html admin template,tailwind framework,html css javascript,tailwind css dashboard,dashboard html css,admin,template admin panel,dashboard html template">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('backend/assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Style Css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">

    <!-- Simplebar Css -->
    <link id="style" href="{{ asset('backend/assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <!-- Swiper Css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/libs/swiper/swiper-bundle.min.css') }}">

</head>


<body class="landing-body">

    <!-- ========== Switcher  ========== -->
    <div id="hs-overlay-switcher" class="hs-overlay hidden ti-offcanvas ti-offcanvas-right" tabindex="-1">
        <div class="ti-offcanvas-header">
            <h5 class="ti-offcanvas-title">
                Switcher
            </h5>
            <button type="button"
                class="ti-btn flex-shrink-0 p-0 transition-none text-defaulttextcolor dark:text-defaulttextcolor/70 hover:text-gray-700 focus:ring-gray-400 focus:ring-offset-white  dark:hover:text-white/80 dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                data-hs-overlay="#hs-overlay-switcher">
                <span class="sr-only">Close modal</span>
                <i class="ri-close-circle-line leading-none text-lg"></i>
            </button>
        </div>
        <div class="ti-offcanvas-body" id="switcher-body">
            <div>
                <div>
                    <p class="switcher-style-head">Theme Color Mode:</p>
                    <div class="grid grid-cols-3 gap-x-6 switcher-style">
                        <div class="flex">
                            <input type="radio" name="theme-style" class="ti-form-radio" id="switcher-light-theme"
                                checked>
                            <label for="switcher-light-theme"
                                class="text-xs text-defaulttextcolor dark:text-defaulttextcolor/70 font-semibold ltr:ml-2 rtl:mr-2 ">Light</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="theme-style" class="ti-form-radio" id="switcher-dark-theme">
                            <label for="switcher-dark-theme"
                                class="text-xs text-defaulttextcolor dark:text-defaulttextcolor/70 font-semibold ltr:ml-2 rtl:mr-2 ">Dark</label>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="switcher-style-head">Directions:</p>
                    <div class="grid grid-cols-3 gap-x-6 switcher-style">
                        <div class="flex">
                            <input type="radio" name="direction" class="ti-form-radio" id="switcher-ltr" checked>
                            <label for="switcher-ltr"
                                class="text-xs font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70 ltr:ml-2 rtl:mr-2 ">LTR</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="direction" class="ti-form-radio" id="switcher-rtl">
                            <label for="switcher-rtl"
                                class="text-xs font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70 ltr:ml-2 rtl:mr-2 ">RTL</label>
                        </div>
                    </div>
                </div>
                <div class="theme-colors">
                    <p class="switcher-style-head">Theme Primary:</p>
                    <div class="flex switcher-style space-x-3 rtl:space-x-reverse">
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-primary-1" type="radio" name="theme-primary"
                                id="switcher-primary" checked>
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-primary-2" type="radio" name="theme-primary"
                                id="switcher-primary1">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-primary-3" type="radio" name="theme-primary"
                                id="switcher-primary2">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-primary-4" type="radio" name="theme-primary"
                                id="switcher-primary3">
                        </div>
                        <div class="ti-form-radio switch-select">
                            <input class="ti-form-radio color-input color-primary-5" type="radio" name="theme-primary"
                                id="switcher-primary4">
                        </div>
                        <div class="ti-form-radio switch-select ltr:pl-0 rtl:pr-0 mt-1 color-primary-light">
                            <div class="theme-container-primary"></div>
                            <div class="pickr-container-primary"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="switcher-style-head">Reset:</p>
                    <div class="flex justify-center">
                        <a id="reset-all" class="ti-btn ti-btn-danger-full mt-4" href="javascript:void(0);">Reset</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========== END Switcher  ========== -->

    <div class="landing-page-wrapper relative">

        <!-- Start::Header -->
         <header class="app-header">

        <!-- Start::main-header-container -->
        <div class="main-header-container container-fluid">

            <!-- Start::header-content-left -->
            <div class="header-content-left">

                <!-- Start::header-element -->
                <div class="header-element">
                    <div class="horizontal-logo">
                        <a href="{{ url('/') }}" class="header-logo">
                            @include('layouts.partials.valex.logo', ['class' => 'white-text'])
                        </a>
                    </div>
                </div>
                <!-- End::header-element -->

                <!-- Start::header-element -->
                <div class="header-element">
                    <!-- Start::header-link -->
                    <a aria-label="anchor" href="javascript:void(0);" class="sidemenu-toggle header-link">
                        <span class="open-toggle">
                            <i class="ri-menu-3-line text-xl"></i>
                        </span>
                    </a>
                    <!-- End::header-link -->
                </div>
                <!-- End::header-element -->

            </div>
            <!-- End::header-content-left -->

            <!-- Start::header-content-right -->
            <div class="header-content-right">

                <!-- Start::header-element -->
                <div class="header-element !items-center">
                    <!-- Start::header-link|switcher-icon -->
                    <div class="lg:hidden block">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="ti-btn ti-btn-primary-full !m-0">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="ti-btn ti-btn-primary-full !m-0">
                                Login
                            </a>
                        @endauth
                        <a aria-label="anchor" href="javascript:void(0);" class="ti-btn m-0 p-2 px-3 ti-btn-primary-light"
                        data-hs-overlay="#hs-overlay-switcher"><i class="ri-settings-3-line animate-spin-slow"></i></a>
                    </div>
                    <!-- End::header-link|switcher-icon -->
                </div>
                <!-- End::header-element -->

            </div>
            <!-- End::header-content-right -->

        </div>
        <!-- End::main-header-container -->

        </header>
       <!-- End::Header -->

        <!-- Start::app-sidebar -->
        <aside class="app-sidebar sticky !top-0" id="sidebar">
            <div class="container-xl !p-0">
                <!-- Start::main-sidebar -->
                <div class="main-sidebar">
                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills flex-column sub-open">
                        <div class="landing-logo-container my-auto hidden lg:block">
                            <div class="responsive-logo">
                                <a class="responsive-logo-light" href="{{ url('/') }}" aria-label="Brand">
                                    @include('layouts.partials.valex.logo', ['class' => 'mx-auto h-[2rem]'])
                                </a>
                            </div>
                        </div>
                        <div class="slide-left hidden" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg></div>
                        <ul class="main-menu">
                            <!-- Start::slide -->
                            <li class="slide">
                                <a class="side-menu__item" href="#home">
                                    <span class="side-menu__label">Home</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                             <!-- Start::slide -->
                             <li class="slide">
                                <a href="#features" class="side-menu__item">
                                    <span class="side-menu__label">Features</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#about" class="side-menu__item">
                                    <span class="side-menu__label">About</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#statistics" class="side-menu__item">
                                    <span class="side-menu__label">Statistics</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#pricing" class="side-menu__item">
                                    <span class="side-menu__label">Pricing</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#testimonials" class="side-menu__item">
                                    <span class="side-menu__label">Clients</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#faq" class="side-menu__item">
                                    <span class="side-menu__label">Faq's</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#contact" class="side-menu__item">
                                    <span class="side-menu__label">Contact</span>
                                </a>
                            </li>
                            <!-- End::slide -->

                        </ul>
                        <div class="slide-right hidden" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
                        <div class="lg:flex hidden space-x-2 rtl:space-x-reverse">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="ti-btn w-[6.375rem] ti-btn-primary-full m-0 p-2 text-center">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="ti-btn w-[6.375rem] ti-btn-primary-full m-0 p-2 text-center">Login</a>
                                <a href="{{ route('register') }}" class="ti-btn w-[6.375rem] ti-btn-light m-0 p-2 text-center">Sign Up</a>
                            @endauth
                            <a aria-label="anchor" href="javascript:void(0);" class="ti-btn m-0 p-2 px-3 ti-btn-light !font-medium"
                                data-hs-overlay="#hs-overlay-switcher"><i class="ri-settings-3-line animate-spin-slow"></i></a>
                        </div>
                    </nav>
                    <!-- End::nav -->

                </div>
                <!-- End::main-sidebar -->
            </div>
        </aside>
        <!-- End::app-sidebar -->

        <!-- Start::main-content -->
        <div class="main-content !p-0 landing-main dark:text-defaulttextcolor/70">
            <!-- Start::Home Content -->
            <div class="landing-banner" id="home">
                <section class="section !pt-[6rem]">
                    <div class="container main-banner-container !pt-3 sm:!pt-[6rem]">
                        <div class="grid grid-cols-12 gap-x-6">
                            <div class="xxl:col-span-2 xl:col-span-2 lg:col-span-2 md:col-span-2 col-span-1"></div>
                            <div class="xxl:col-span-8 xl:col-span-8 lg:col-span-8 md:col-span-8 col-span-10">
                                <div class="py-4 pb-lg-0 text-center">
                                    <div class="mb-3">
                                        <h5 class="font-semibold text-fixed-white op-9">Manage Your Veterinary Clinic</h5>
                                    </div>
                                    <p class="landing-banner-heading mb-3 cursor-default">Welcome to VetConnect Portfolio</p>
                                    <div class="fs-16 mb-5 text-fixed-white op-7"> VetConnect is a modern solution for managing appointments, records, and pets. Streamline your clinic operations and provide better care for animals.</div>
                                    <a href="#features" class="m-1 ti-btn ti-btn-primary-full">
                                        Discover More
                                        <i class="fe fe-eye ms-2 align-middle"></i>
                                    </a>
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="m-1 ti-btn ti-btn-primary-full">
                                            Go to Dashboard
                                            <i class="fe fe-arrow-right rtl:rotate-180 ms-2 rtl:ms-0 align-middle"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="m-1 ti-btn ti-btn-primary-full">
                                            Get Started
                                            <i class="fe fe-arrow-right rtl:rotate-180 ms-2 rtl:ms-0 align-middle"></i>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                            <div class="xxl:col-span-2 xl:col-span-2 lg:col-span-2 md:col-span-2 col-span-1"></div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- End::Home Content -->

            <!-- Start:: Section-2 -->
            <section class="section text-defaulttextcolor dark:text-defaulttextcolor/70  section-bg " id="features">
                <div class="container text-center position-relative">
                    <p class="text-[0.75rem] font-semibold text-success mb-1">
                        <span class="landing-section-heading">Features</span>
                    </p>
                    <div class="landing-title"></div>
                    <h3 class="font-semibold mb-2">VetConnect Main Features</h3>
                    <div class="row justify-content-center">
                        <div class="col-xl-7">
                            <p class="text-textmuted fs-15 mb-5 font-normal">We provide the best tools for veterinary professionals to manage their daily tasks efficiently.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-x-6 justify-center">
                        <div class="xl:col-span-12 col-span-12">
                            <div class="grid grid-cols-12 gap-x-6 justify-evenly">
                                <div class="xl:col-span-3 lg:col-span-6 md:col-span-6 sm:col-span-6 col-span-12 mb-4">
                                    <div class="card rounded-sm bg-white dark:bg-bodybg features main-features main-features-4 p-6 active"
                                        data-wow-delay="0.1s">
                                        <div class="bg-img mb-2">
                                            <i class="ri-calendar-check-line text-[2rem] text-primary"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-bold">Appointment Management</h5>
                                            <p class="mb-0">Easily schedule and manage pet appointments with automated reminders and calendar integration.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="xl:col-span-3 lg:col-span-6 md:col-span-6 sm:col-span-6 col-span-12 mb-4">
                                    <div
                                        class="card rounded-sm bg-white dark:bg-bodybg features main-features main-features-2 wow p-6">
                                        <div class="bg-img mb-2">
                                            <i class="ri-file-list-3-line text-[2rem] text-primary"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-bold">Medical Records</h5>
                                            <p class="mb-0">Maintain detailed medical histories for every pet, including vaccinations, treatments, and prescriptions.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="xl:col-span-3 lg:col-span-6 md:col-span-6 sm:col-span-6 col-span-12 mb-4">
                                    <div
                                        class="card rounded-sm bg-white dark:bg-bodybg features main-features main-features-3 wow p-6">
                                        <div class="bg-img mb-2">
                                            <i class="ri-user-heart-line text-[2rem] text-primary"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-bold">Pet Owner Portal</h5>
                                            <p class="mb-0">Dedicated portal for pet owners to view their pet's records and book appointments online.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="xl:col-span-3 lg:col-span-6 md:col-span-6 sm:col-span-6 col-span-12 mb-4">
                                    <div
                                        class="card rounded-sm bg-white dark:bg-bodybg features main-features main-features-4 wow fadeInUp reveal revealleft p-6">
                                        <div class="bg-img mb-2">
                                            <i class="ri-bar-chart-box-line text-[2rem] text-primary"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-bold">Insightful Reporting</h5>
                                            <p class="mb-0">Generate reports on clinic performance, inventory usage, and financial summaries easily.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-2 -->

            <!-- Start:: Section-5 -->
            <section class="section landing-Features text-defaulttextcolor dark:text-defaulttextcolor/70 "
                id="features_used">
                <div class="container text-center">
                    <p class="text-[0.75rem] font-semibold text-success mb-1"><span
                            class="landing-section-heading">Tech Stack</span></p>
                    <h3 class="font-semibold mb-2 !text-white">Powered by Modern Technologies</h3>
                    <div>
                        <div class="xl:col-span-7 col-span-12">
                            <p class="text-white opacity-[0.8] text-[0.9375rem] mb-4 font-normal">VetConnect is built using the latest technologies to ensure stability, security, and performance.</p>
                        </div>
                    </div>
                    <div class="text-start">
                        <div class="justify-center">
                            <div class="">
                                <div class="feature-logos sm:mt-[3rem] flex-wrap">
                                    <div class="sm:ms-[3rem] ms-2 text-center">
                                        <img src="{{ asset('backend/assets/images/media/landing/web/1.png') }}" alt="image"
                                            class="featur-icon">
                                        <h5 class="mt-3 text-white text-[1.25rem] ">Tailwind</h5>
                                    </div>
                                    <div class="sm:ms-[3rem] ms-2 text-center">
                                        <img src="{{ asset('backend/assets/images/media/landing/web/2.png') }}" alt="image"
                                            class="featur-icon">
                                        <h5 class="mt-3 text-white text-[1.25rem] ">Laravel</h5>
                                    </div>
                                    <div class="sm:ms-[3rem] ms-2 text-center">
                                        <i class="ri-database-2-line text-[4rem] text-white"></i>
                                        <h5 class="mt-3 text-white text-[1.25rem] ">MySQL</h5>
                                    </div>
                                    <div class="sm:ms-[3rem] ms-2 text-center">
                                        <i class="ri-javascript-line text-[4rem] text-white"></i>
                                        <h5 class="ms-3 text-white text-[1.25rem] ">JavaScript</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-5 -->

            <!-- Start:: Section-3 -->
            <section class="section bg-white dark:bg-bodybg text-defaulttextcolor dark:text-defaulttextcolor/70 "
                id="about">
                <div class="container text-center">
                    <p class="text-[0.75rem] font-semibold text-success mb-1"><span class="landing-section-heading">Our
                            Mission</span>
                    </p>
                    <div class="landing-title"></div>
                    <h3 class="font-semibold mb-2"> Caring for animals, connecting with owners. </h3>
                    <p class="text-textmuted fs-15 mb-3 font-normal">Our goal is to bridge the gap between veterinarians and pet owners through technology.</p>
                    <div class="grid grid-cols-12 justify-center items-center mx-0">
                        <div class="xxl:col-span-5 xl:col-span-5 lg:col-span-5 col-span-12 text-center">
                            <img src="{{ asset('backend/assets/images/authentication/9.png') }}" alt="" class="img-fluid inline-flex">
                        </div>
                        <div
                            class="xxl:col-span-7 xl:col-span-7 lg:col-span-7 col-span-12 pt-5 pb-0 px-lg-2 px-5 text-start">
                            <h4 class="text-lg-start font-medium mb-4">A complete ecosystem for veterinary clinics.</h4>
                            <div class="grid grid-cols-12">
                                <div class="col-span-12 md:col-span-12">
                                    <div class="flex mb-2">
                                        <span>
                                            <i class='bx bxs-badge-check text-primary text-[1.125rem]'></i>
                                        </span>
                                        <div class="ms-2">
                                            <h6 class="font-medium mb-0">Unified Record System</h6>
                                            <p class=" text-textmuted mb-3"> No more paper files. Access all pet data from any device, anywhere, anytime. </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-12">
                                    <div class="flex mb-2">
                                        <span>
                                            <i class='bx bxs-badge-check text-primary text-[1.125rem]'></i>
                                        </span>
                                        <div class="ms-2">
                                            <h6 class="font-medium mb-0">Automated Reminders</h6>
                                            <p class=" text-textmuted mb-3"> Send automatic SMS or Email reminders for upcoming vaccinations or follow-ups. </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-12">
                                    <div class="flex mb-2">
                                        <span>
                                            <i class='bx bxs-badge-check text-primary text-[1.125rem]'></i>
                                        </span>
                                        <div class="ms-2">
                                            <h6 class="font-medium mb-0">Secure & Reliable</h6>
                                            <p class=" text-textmuted">Your data is stored securely with regular backups and industry-standard encryption. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-3 -->

            <section
                class="section  dark:!bg-black/10 section-bg text-defaulttextcolor dark:text-defaulttextcolor/70"
                id="statistics">
                <div class="container text-center position-relative">
                    <p class="text-[0.75rem] font-semibold text-success mb-1"><span
                            class="landing-section-heading">STATISTICS</span></p>
                    <h3 class="font-semibold mb-2 text-defaulttextcolor dark:text-defaulttextcolor/70 ">Trusted by Professionals</h3>
                    <div class="">
                        <div class="xl:col-span-7 col-span-12">
                            <p class="text-[#8c9097] text-[0.9375rem] mb-5 font-normal">Join the growing community of veterinary clinics using VetConnect.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-x-6 container">
                        <div class="xl:col-span-1"></div>
                        <div class="xl:col-span-2 lg:col-span-4 md:col-span-6 sm:col-span-12 col-span-12 mb-3">
                            <div
                                class="p-4 text-center !rounded-sm bg-white dark:bg-bodybg border dark:border-defaultborder/10">
                                <span class="mb-4 avatar avatar-lg avatar-rounded bg-primary/10 !text-primary">
                                    <i class='text-[1.5rem] bx bx-spreadsheet'></i>
                                </span>
                                <h3 class="font-semibold mb-0 text-dark">500+</h3>
                                <p class="mb-1 text-[0.875rem] opacity-[0.7] text-[#8c9097] ">
                                    Active Clinics
                                </p>
                            </div>
                        </div>
                        <div class="xl:col-span-2 lg:col-span-4 md:col-span-6 sm:col-span-12 col-span-12 mb-3">
                            <div
                                class="p-4 text-center !rounded-sm !bg-white dark:!bg-bodybg border dark:border-defaultborder/10">
                                <span class="mb-4 avatar avatar-lg avatar-rounded bg-primary/10 !text-primary">
                                    <i class='text-[1.5rem] bx bx-user-plus'></i>
                                </span>
                                <h3 class="font-semibold mb-0 text-dark">50K+</h3>
                                <p class="mb-1 text-[0.875rem] opacity-[0.7] text-[#8c9097] ">
                                    Pets Registed
                                </p>
                            </div>
                        </div>
                        <div class="xl:col-span-2 lg:col-span-4 md:col-span-6 sm:col-span-12 col-span-12 mb-3">
                            <div
                                class="p-4 text-center !rounded-sm !bg-white dark:!bg-bodybg border dark:border-defaultborder/10">
                                <span class="mb-4 avatar avatar-lg avatar-rounded bg-primary/10 !text-primary">
                                    <i class='text-[1.5rem] bx bx-calendar-heart'></i>
                                </span>
                                <h3 class="font-semibold mb-0 text-dark">200K+</h3>
                                <p class="mb-1 text-[0.875rem] opacity-[0.7] text-[#8c9097] ">
                                    Appointments Made
                                </p>
                            </div>
                        </div>
                        <div class="xl:col-span-2 lg:col-span-4 md:col-span-6 sm:col-span-12 col-span-12 mb-3">
                            <div
                                class="p-4 text-center !rounded-sm !bg-white dark:!bg-bodybg  border dark:border-defaultborder/10">
                                <span class="mb-4 avatar avatar-lg avatar-rounded bg-primary/10 !text-primary">
                                    <i class='text-[1.5rem] bx bx-user-circle'></i>
                                </span>
                                <h3 class="font-semibold mb-0 text-dark">1K+</h3>
                                <p class="mb-1 text-[0.875rem] opacity-[0.7] text-[#8c9097] ">
                                    Expert Vets
                                </p>
                            </div>
                        </div>
                        <div class="xl:col-span-2 lg:col-span-4 md:col-span-6 sm:col-span-12 col-span-12 mb-3">
                            <div
                                class="p-4 text-center !rounded-sm bg-white dark:!bg-bodybg  border dark:border-defaultborder/10">
                                <span class="mb-4 avatar avatar-lg avatar-rounded bg-primary/10 !text-primary">
                                    <i class='text-[1.5rem] bx bx-star'></i>
                                </span>
                                <h3 class="font-semibold mb-0 text-dark">4.9/5</h3>
                                <p class="mb-1 text-[0.875rem] opacity-[0.7] text-[#8c9097] ">
                                    User Rating
                                </p>
                            </div>
                        </div>
                        <div class="xl:col-span-1"></div>
                    </div>
                </div>
            </section>


            <!-- Start:: Section-8 -->
            <section class="section bg-white dark:bg-bodybg text-defaulttextcolor dark:text-defaulttextcolor/70 text-[0.813rem] " id="pricing">
                <div class="container text-center">
                    <p class="text-[0.75rem] font-semibold text-success mb-1"><span
                            class="landing-section-heading">PRICING</span></p>
                    <h3 class="font-semibold mb-2">Comes with most affordable pricing range.</h3>
                    <div class="row justify-center">
                        <div class="col-xl-9">
                            <p class="text-[#8c9097] text-[0.9375rem] mb-5 font-normal">Choose the plan that fits your clinic size. No hidden fees.</p>
                        </div>
                    </div>
                    <!-- Pricing content simplified for VetConnect -->
                     <div class="grid grid-cols-12 justify-center gap-x-6">
                        <div class="xl:col-span-4 col-span-12 mb-4">
                             <div class="p-4 border dark:border-defaultborder/10 rounded-sm bg-white dark:bg-bodybg">
                                <h6 class="font-semibold text-center text-[1rem]">SOLO VET</h6>
                                <div class="py-4 flex items-center justify-center">
                                    <div class="text-end">
                                        <p class="text-[1.5625rem] font-semibold mb-0">Free</p>
                                        <p class="text-[#8c9097] text-[0.6875rem] font-semibold mb-0">For trial / Small clinics</p>
                                    </div>
                                </div>
                                <ul class="list-unstyled text-center text-[0.75rem] px-4 pt-4 mb-4">
                                    <li class="mb-2 text-[#8c9097]">Up to 50 Pets</li>
                                    <li class="mb-2 text-[#8c9097]">Basic Appointment Booking</li>
                                    <li class="mb-2 text-[#8c9097]">Medical Records</li>
                                    <li class="mb-2 text-[#8c9097]">Email Support</li>
                                </ul>
                                <button class="ti-btn ti-btn-primary w-full">Start Free</button>
                             </div>
                        </div>
                        <div class="xl:col-span-4 col-span-12 mb-4">
                             <div class="p-4 border dark:border-defaultborder/10 rounded-sm bg-white dark:bg-bodybg border-primary shadow-md">
                                <h6 class="font-semibold text-center text-[1rem] text-primary">PROFESSIONAL</h6>
                                <div class="py-4 flex items-center justify-center">
                                    <div class="text-end">
                                        <p class="text-[1.5625rem] font-semibold mb-0 text-primary">$49</p>
                                        <p class="text-[#8c9097] text-[0.6875rem] font-semibold mb-0">per month</p>
                                    </div>
                                </div>
                                <ul class="list-unstyled text-center text-[0.75rem] px-4 pt-4 mb-4">
                                    <li class="mb-2 text-[#8c9097]">Unlimited Pets</li>
                                    <li class="mb-2 text-[#8c9097]">Advanced Reminders (SMS)</li>
                                    <li class="mb-2 text-[#8c9097]">Inventory Management</li>
                                    <li class="mb-2 text-[#8c9097]">Priority Support</li>
                                </ul>
                                <button class="ti-btn ti-btn-primary-full w-full">Choose Plan</button>
                             </div>
                        </div>
                        <div class="xl:col-span-4 col-span-12 mb-4">
                             <div class="p-4 border dark:border-defaultborder/10 rounded-sm bg-white dark:bg-bodybg">
                                <h6 class="font-semibold text-center text-[1rem]">MULTIPLE BRANCH</h6>
                                <div class="py-4 flex items-center justify-center">
                                    <div class="text-end">
                                        <p class="text-[1.5625rem] font-semibold mb-0">$99</p>
                                        <p class="text-[#8c9097] text-[0.6875rem] font-semibold mb-0">per month</p>
                                    </div>
                                </div>
                                <ul class="list-unstyled text-center text-[0.75rem] px-4 pt-4 mb-4">
                                    <li class="mb-2 text-[#8c9097]">Up to 5 Branches</li>
                                    <li class="mb-2 text-[#8c9097]">Consolidated Dashboard</li>
                                    <li class="mb-2 text-[#8c9097]">Staff Activity Tracking</li>
                                    <li class="mb-2 text-[#8c9097]">24/7 Dedicated Support</li>
                                </ul>
                                <button class="ti-btn ti-btn-primary w-full">Contact Sales</button>
                             </div>
                        </div>
                     </div>
                </div>
            </section>
            <!-- End:: Section-8 -->


            <!-- Start:: Section-6 -->
            <section class="section landing-testimonials " id="testimonials">
                <div class="container text-center">
                    <p class="fs-12 font-semibold text-success mb-1"><span
                            class="landing-section-heading">TESTIMONIALS</span>
                    </p>
                    <div class="landing-title"></div>
                    <h3 class="font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70 mb-2">What Veterinarians Are Saying</h3>
                    <p class="text-muted fs-15 mb-5 font-normal">Real feedback from real users of VetConnect.</p>
                    <!-- Simplified Testimonials for Demo -->
                     <div class="grid grid-cols-12 gap-x-6">
                        <div class="xl:col-span-4 col-span-12 mb-4">
                            <div class="p-6 border dark:border-defaultborder/10 bg-white dark:bg-bodybg rounded-sm text-center">
                                <p class="italic mb-4">"VetConnect has completely changed how we handle appointments. No more double bookings!"</p>
                                <p class="font-bold mb-0">Dr. Sarah Moore</p>
                                <p class="text-xs text-muted">Happy Pet Clinic</p>
                            </div>
                        </div>
                        <div class="xl:col-span-4 col-span-12 mb-4">
                            <div class="p-6 border dark:border-defaultborder/10 bg-white dark:bg-bodybg rounded-sm text-center">
                                <p class="italic mb-4">"The pet owner portal is a game changer. Clients love being able to see their records."</p>
                                <p class="font-bold mb-0">Dr. James Wilson</p>
                                <p class="text-xs text-muted">Wilson Veterinary Hospital</p>
                            </div>
                        </div>
                        <div class="xl:col-span-4 col-span-12 mb-4">
                            <div class="p-6 border dark:border-defaultborder/10 bg-white dark:bg-bodybg rounded-sm text-center">
                                <p class="italic mb-4">"Super easy to use and very professional looking. Highly recommend for any clinic."</p>
                                <p class="font-bold mb-0">Dr. Emily Chen</p>
                                <p class="text-xs text-muted">City Vet Center</p>
                            </div>
                        </div>
                     </div>
                </div>
            </section>
            <!-- End:: Section-6 -->


            <!-- Start:: Section-9 -->
            <section
                class="section bg-[#f9fafb] section-bg text-defaulttextcolor dark:text-defaulttextcolor/70 text-[0.813rem]"
                id="faq">
                <div class="container text-center">
                    <p class="text-[0.75rem] font-semibold text-success mb-1"><span
                            class="landing-section-heading">F.A.Q</span></p>
                    <h3 class="font-semibold mb-2">Frequently asked questions ?</h3>
                    <div class="row justify-center">
                        <div class="">
                            <p class="text-[#8c9097] text-[0.9375rem] mb-5 font-normal">We have shared some of the most
                                frequently asked questions to help you out.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-x-6">
                        <div class="xl:col-span-12 col-span-12">
                            <div class="accordion accordion-customicon1 accordion-primary accordions-items-seperate"
                                id="accordionFAQ1">
                                <div class="hs-accordion-group">
                                    <div class="hs-accordion bg-white dark:bg-bodybg border dark:border-defaultborder/10 mt-[0.5rem] rounded-sm"
                                        id="faq-one"> <button type="button"
                                            class="hs-accordion-toggle hs-accordion-active:!text-primary hs-accordion-active:border dark:border-defaultborder/10-b hs-accordion-active:bg-primary/10 justify-between inline-flex items-center w-full font-semibold text-start text-[0.85rem] transition py-3 px-4 dark:text-gray-200 dark:hover:text-white/80"
                                            aria-controls="faq-collapse-one"> Is my pet data secure?
                                            <i class="ri-add-line hs-accordion-active:hidden"></i>
                                            <i class="ri-subtract-line hs-accordion-active:block hidden"></i> </button>
                                        <div id="faq-collapse-one"
                                            class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                                            aria-labelledby="faq-one">
                                            <div class="p-5 text-start">
                                                <p class="text-defaulttextcolor dark:text-defaulttextcolor/70 ">
                                                   Yes, absolutely. We use industry-standard encryption and regular backups to ensure your data is always safe and accessible only to authorized personnel.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hs-accordion bg-white dark:bg-bodybg border dark:border-defaultborder/10 mt-[0.5rem] rounded-sm"
                                        id="faq-two"> <button type="button"
                                            class="hs-accordion-toggle hs-accordion-active:!text-primary hs-accordion-active:border dark:border-defaultborder/10-b hs-accordion-active:bg-primary/10 justify-between inline-flex items-center w-full font-semibold text-start text-[0.85rem] transition py-3 px-4 dark:text-gray-200 dark:hover:text-white/80"
                                            aria-controls="faq-collapse-two"> Can I migrate my data from my old system?
                                            <i class="ri-add-line hs-accordion-active:hidden"></i>
                                            <i class="ri-subtract-line hs-accordion-active:block hidden"></i> </button>
                                        <div id="faq-collapse-two"
                                            class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                                            aria-labelledby="faq-two">
                                            <div class="p-5 text-start">
                                                <p class="text-defaulttextcolor dark:text-defaulttextcolor/70 ">
                                                   Yes, we provide data migration tools and support for most common veterinary software. Contact our sales team for assistance with migration.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hs-accordion bg-white dark:bg-bodybg border dark:border-defaultborder/10 mt-[0.5rem] rounded-sm"
                                        id="faq-three"> <button type="button"
                                            class="hs-accordion-toggle hs-accordion-active:!text-primary hs-accordion-active:border dark:border-defaultborder/10-b hs-accordion-active:bg-primary/10 justify-between inline-flex items-center w-full font-semibold text-start text-[0.85rem] transition py-3 px-4 dark:text-gray-200 dark:hover:text-white/80"
                                            aria-controls="faq-collapse-three"> Do you offer 24/7 support?
                                            <i class="ri-add-line hs-accordion-active:hidden"></i>
                                            <i class="ri-subtract-line hs-accordion-active:block hidden"></i> </button>
                                        <div id="faq-collapse-three"
                                            class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                                            aria-labelledby="faq-three">
                                            <div class="p-5 text-start">
                                                <p class="text-defaulttextcolor dark:text-defaulttextcolor/70 ">
                                                   Yes, for our Professional and Branch plans, we offer round-the-clock technical support via chat and email.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-9 -->

            <!-- Start:: Section-10 -->
            <section class="section landing-contact" id="contact">
                <div class="container text-center">
                    <p class="text-[0.75rem] font-semibold text-success mb-1"><span
                            class="landing-section-heading">Contact Us</span></p>
                    <h3 class="font-semibold mb-2 text-defaulttextcolor">Have Questions? Get in Touch!</h3>
                    <div class="row justify-center">
                        <div class="">
                            <p class="text-textmuted text-[0.9375rem] mb-5 font-normal">Our team is ready to help you streamline your clinic operations.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-x-6 text-start">
                        <div class="xxl:col-span-1 xl:col-span-1 lg:col-span-1 md:col-span-1 col-span-12"></div>
                        <div class="xxl:col-span-5 xl:col-span-5 lg:col-span-5 md:col-span-5 col-span-12">
                            <div class="p-6 bg-white dark:bg-bodybg rounded-sm border dark:border-defaultborder/10">
                                <form action="#">
                                    <div class="grid grid-cols-12 gap-y-4">
                                        <div class="col-span-12">
                                            <label for="contact-name" class="form-label text-defaulttextcolor">Full Name</label>
                                            <input type="text" class="form-control" id="contact-name" placeholder="Enter Name">
                                        </div>
                                        <div class="col-span-12">
                                            <label for="contact-email" class="form-label text-defaulttextcolor">Email Address</label>
                                            <input type="email" class="form-control" id="contact-email" placeholder="Enter Email">
                                        </div>
                                        <div class="col-span-12">
                                            <label for="contact-message" class="form-label text-defaulttextcolor">Message</label>
                                            <textarea class="form-control" id="contact-message" rows="4" placeholder="How can we help?"></textarea>
                                        </div>
                                        <div class="col-span-12 mt-2">
                                            <button type="submit" class="ti-btn ti-btn-primary-full w-full">Send Message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="xxl:col-span-5 xl:col-span-5 lg:col-span-5 md:col-span-5 col-span-12">
                             <div class="p-6 text-defaulttextcolor text-[1rem]">
                                <div class="mb-4">
                                    <h6 class="font-bold text-defaulttextcolor mb-2">Office Location</h6>
                                    <p class="text-textmuted"><i class="ri-map-pin-line me-2 text-primary"></i> 123 Veterinary St, Pet City, PC 12345</p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="font-bold text-defaulttextcolor mb-2">Contact Details</h6>
                                    <p class="text-textmuted mb-1"><i class="ri-mail-line me-2 text-primary"></i> support@vetconnect.com</p>
                                    <p class="text-textmuted"><i class="ri-phone-line me-2 text-primary"></i> +1 (234) 567-890</p>
                                </div>
                                <div>
                                    <h6 class="font-bold text-defaulttextcolor mb-2">Social Connect</h6>
                                    <div class="flex gap-x-3 mt-2">
                                        <a href="#" class="avatar avatar-sm avatar-rounded bg-primary/10 text-primary hover:bg-primary hover:text-white"><i class="ri-facebook-line"></i></a>
                                        <a href="#" class="avatar avatar-sm avatar-rounded bg-primary/10 text-primary hover:bg-primary hover:text-white"><i class="ri-twitter-x-line"></i></a>
                                        <a href="#" class="avatar avatar-sm avatar-rounded bg-primary/10 text-primary hover:bg-primary hover:text-white"><i class="ri-linkedin-line"></i></a>
                                    </div>
                                </div>
                             </div>
                        </div>
                        <div class="xxl:col-span-1 xl:col-span-1 lg:col-span-1 md:col-span-1 col-span-12"></div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-10 -->

            <div class="text-center landing-main-footer py-3">
                <span class="text-[#8c9097] text-[0.9375rem] dark:text-defaulttextcolor/50"> Copyright © <span
                        id="year"></span> <a href="javascript:void(0);" class="text-primary font-semibold">VetConnect</a>.
                    All
                    rights
                    reserved
                </span>
            </div>

        </div>
        <!-- End::main-content -->

    </div>


    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill text-xl"></i></span>
    </div>

    <!-- SCRIPTS -->

    <!-- Simplebar JS -->
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('backend/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- Swiper JS -->
    <script src="{{ asset('backend/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Preline JS -->
    <script src="{{ asset('backend/assets/libs/preline/preline.js') }}"></script>

    <!-- Defaultmenu JS -->
    <script src="{{ asset('backend/assets/js/defaultmenu.js') }}"></script>

    <!-- Sticky JS -->
    <script src="{{ asset('backend/assets/js/sticky.js') }}"></script>

    <!-- Landing JS -->
    <script src="{{ asset('backend/assets/js/landing.js') }}"></script>

    <!-- Custom-Switcher JS -->
    <script src="{{ asset('backend/assets/js/custom-switcher.js') }}"></script>

</body>

</html>