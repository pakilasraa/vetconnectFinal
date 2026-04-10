<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-nav-layout="vertical" data-vertical-style="default" data-header-position="fixed" data-menu-position="fixed" class="light" data-header-styles="light" data-menu-styles="light">

<head>
    @include('layouts.partials.valex.head')
</head>

<body>

  <!-- ========== Switcher  ========== -->
  <div id="hs-overlay-switcher" class="hs-overlay hidden ti-offcanvas ti-offcanvas-right !border-0" tabindex="-1">
      <div class="ti-offcanvas-header z-10 relative">
        <h5 class="ti-offcanvas-title">
          Switcher
        </h5>
        <button type="button"
          class="ti-btn flex-shrink-0 p-0  transition-none text-defaulttextcolor dark:text-defaulttextcolor/70 hover:text-gray-700 focus:ring-gray-400 focus:ring-offset-white  dark:hover:text-white/80 dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
          data-hs-overlay="#hs-overlay-switcher">
          <span class="sr-only">Close modal</span>
          <i class="ri-close-circle-line leading-none text-lg"></i>
        </button>
      </div>
      <div class="ti-offcanvas-body !p-0 !border-b dark:border-white/10 z-10 relative !h-auto">
        <div class="flex rtl:space-x-reverse" aria-label="Tabs" role="tablist">
          <button type="button"
            class="hs-tab-active:bg-success/20 w-full !py-2 !px-4 hs-tab-active:border-b-transparent text-defaultsize border-0 hs-tab-active:text-success dark:hs-tab-active:bg-success/20 dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-success -mb-px bg-white font-semibold text-center  text-defaulttextcolor dark:text-defaulttextcolor/70 rounded-none hover:text-gray-700 dark:bg-bodybg dark:border-white/10  active"
            id="switcher-item-1" data-hs-tab="#switcher-1" aria-controls="switcher-1" role="tab">
            Theme Style
          </button>
          <button type="button"
            class="hs-tab-active:bg-success/20 w-full !py-2 !px-4 hs-tab-active:border-b-transparent text-defaultsize border-0 hs-tab-active:text-success dark:hs-tab-active:bg-success/20 dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-success -mb-px  bg-white font-semibold text-center  text-defaulttextcolor dark:text-defaulttextcolor/70 rounded-none hover:text-gray-700 dark:bg-bodybg dark:border-white/10  dark:hover:text-gray-300"
            id="switcher-item-2" data-hs-tab="#switcher-2" aria-controls="switcher-2" role="tab">
            Theme Colors
          </button>
        </div>
      </div>
      <div class="ti-offcanvas-body !h-full overflow-auto" id="switcher-body">
        <div id="switcher-1" role="tabpanel" aria-labelledby="switcher-item-1" class="space-y-6">
          <div>
            <p class="switcher-style-head">Theme Color Mode:</p>
            <div class="grid grid-cols-3 switcher-style">
              <div class="flex items-center">
                <input type="radio" name="theme-style" class="ti-form-radio" id="switcher-light-theme" checked>
                <label for="switcher-light-theme"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Light</label>
              </div>
              <div class="flex items-center">
                <input type="radio" name="theme-style" class="ti-form-radio" id="switcher-dark-theme">
                <label for="switcher-dark-theme"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Dark</label>
              </div>
            </div>
          </div>
          <div class="!mt-0">
            <p class="switcher-style-head">Directions:</p>
            <div class="grid grid-cols-3  switcher-style">
              <div class="flex items-center">
                <input type="radio" name="direction" class="ti-form-radio" id="switcher-ltr" checked>
                <label for="switcher-ltr" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">LTR</label>
              </div>
              <div class="flex items-center">
                <input type="radio" name="direction" class="ti-form-radio" id="switcher-rtl">
                <label for="switcher-rtl" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">RTL</label>
              </div>
            </div>
          </div>
          <div class="!mt-0">
            <p class="switcher-style-head">Navigation Styles:</p>
            <div class="grid grid-cols-3  switcher-style">
              <div class="flex items-center">
                <input type="radio" name="navigation-style" class="ti-form-radio" id="switcher-vertical" checked>
                <label for="switcher-vertical"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Vertical</label>
              </div>
              <div class="flex items-center">
                <input type="radio" name="navigation-style" class="ti-form-radio" id="switcher-horizontal">
                <label for="switcher-horizontal"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Horizontal</label>
              </div>
            </div>
          </div>
          <div class="!mt-0 navigation-menu-styles">
            <p class="switcher-style-head">Navigation Menu Style:</p>
            <div class="grid grid-cols-2 gap-2 switcher-style">
              <div class="flex">
                <input type="radio" name="navigation-data-menu-styles" class="ti-form-radio" id="switcher-menu-click"
                  >
                <label for="switcher-menu-click" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Menu
                  Click</label>
              </div>
              <div class="flex">
                <input type="radio" name="navigation-data-menu-styles" class="ti-form-radio" id="switcher-menu-hover">
                <label for="switcher-menu-hover" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Menu
                  Hover</label>
              </div>
              <div class="flex">
                <input type="radio" name="navigation-data-menu-styles" class="ti-form-radio" id="switcher-icon-click">
                <label for="switcher-icon-click" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Icon
                  Click</label>
              </div>
              <div class="flex">
                <input type="radio" name="navigation-data-menu-styles" class="ti-form-radio" id="switcher-icon-hover">
                <label for="switcher-icon-hover" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Icon
                  Hover</label>
              </div>
            </div>
          </div>
          <div class="!mt-0 sidemenu-layout-styles">
            <p class="switcher-style-head">Sidemenu Layout Syles:</p>
            <div class="grid grid-cols-2 gap-2 switcher-style">
              <div class="flex">
                <input type="radio" name="sidemenu-layout-styles" class="ti-form-radio" id="switcher-default-menu" checked>
                <label for="switcher-default-menu"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold ">Default
                  Menu</label>
              </div>
              <div class="flex">
                <input type="radio" name="sidemenu-layout-styles" class="ti-form-radio" id="switcher-closed-menu">
                <label for="switcher-closed-menu" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold ">
                  Closed
                  Menu</label>
              </div>
              <div class="flex">
                <input type="radio" name="sidemenu-layout-styles" class="ti-form-radio" id="switcher-icontext-menu">
                <label for="switcher-icontext-menu" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold ">Icon
                  Text</label>
              </div>
              <div class="flex">
                <input type="radio" name="sidemenu-layout-styles" class="ti-form-radio" id="switcher-icon-overlay">
                <label for="switcher-icon-overlay" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold ">Icon
                  Overlay</label>
              </div>
              <div class="flex">
                <input type="radio" name="sidemenu-layout-styles" class="ti-form-radio" id="switcher-detached">
                <label for="switcher-detached"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold ">Detached</label>
              </div>
              <div class="flex">
                <input type="radio" name="sidemenu-layout-styles" class="ti-form-radio" id="switcher-double-menu">
                <label for="switcher-double-menu" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Double
                  Menu</label>
              </div>
            </div>
          </div>
          <div class="!mt-0">
            <p class="switcher-style-head">Page Styles:</p>
            <div class="grid grid-cols-3  switcher-style">
              <div class="flex">
                <input type="radio" name="data-page-styles" class="ti-form-radio" id="switcher-regular" checked>
                <label for="switcher-regular"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Regular</label>
              </div>
              <div class="flex">
                <input type="radio" name="data-page-styles" class="ti-form-radio" id="switcher-classic">
                <label for="switcher-classic"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Classic</label>
              </div>
              <div class="flex">
                <input type="radio" name="data-page-styles" class="ti-form-radio" id="switcher-modern">
                <label for="switcher-modern"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold"> Modern</label>
              </div>
            </div>
          </div>
          <div class="!mt-0">
            <p class="switcher-style-head">Layout Width Styles:</p>
            <div class="grid grid-cols-3 switcher-style">
              <div class="flex">
                <input type="radio" name="layout-width" class="ti-form-radio" id="switcher-full-width" checked>
                <label for="switcher-full-width"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">FullWidth</label>
              </div>
              <div class="flex">
                <input type="radio" name="layout-width" class="ti-form-radio" id="switcher-boxed">
                <label for="switcher-boxed" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Boxed</label>
              </div>
            </div>
          </div>
          <div class="!mt-0">
            <p class="switcher-style-head">Menu Positions:</p>
            <div class="grid grid-cols-3  switcher-style">
              <div class="flex">
                <input type="radio" name="data-menu-positions" class="ti-form-radio" id="switcher-menu-fixed" checked>
                <label for="switcher-menu-fixed"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Fixed</label>
              </div>
              <div class="flex">
                <input type="radio" name="data-menu-positions" class="ti-form-radio" id="switcher-menu-scroll">
                <label for="switcher-menu-scroll"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Scrollable </label>
              </div>
            </div>
          </div>
          <div class="!mt-0">
            <p class="switcher-style-head">Header Positions:</p>
            <div class="grid grid-cols-3 switcher-style">
              <div class="flex">
                <input type="radio" name="data-header-positions" class="ti-form-radio" id="switcher-header-fixed" checked>
                <label for="switcher-header-fixed" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">
                  Fixed</label>
              </div>
              <div class="flex">
                <input type="radio" name="data-header-positions" class="ti-form-radio" id="switcher-header-scroll">
                <label for="switcher-header-scroll"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Scrollable
                </label>
              </div>
            </div>
          </div>
          <div class="!mt-0">
            <p class="switcher-style-head">Loader:</p>
            <div class="grid grid-cols-3 switcher-style">
              <div class="flex">
                <input type="radio" name="page-loader" class="ti-form-radio" id="switcher-loader-enable" checked>
                <label for="switcher-loader-enable" class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">
                  Enable</label>
              </div>
              <div class="flex">
                <input type="radio" name="page-loader" class="ti-form-radio" id="switcher-loader-disable">
                <label for="switcher-loader-disable"
                  class="text-defaultsize text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2  font-semibold">Disable
                </label>
              </div>
            </div>
        </div>
        </div>
        <div id="switcher-2" class="hidden" role="tabpanel" aria-labelledby="switcher-item-2">
          <div class="theme-colors">
            <p class="switcher-style-head">Menu Colors:</p>
            <div class="flex switcher-style space-x-3 rtl:space-x-reverse">
              <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                <input class="hs-tooltip-toggle ti-form-radio color-input color-white" type="radio" name="menu-colors"
                  id="switcher-menu-light" checked>
                <span
                  class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                  role="tooltip">
                  Light Menu
                </span>
              </div>
              <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                <input class="hs-tooltip-toggle ti-form-radio color-input color-dark" type="radio" name="menu-colors"
                  id="switcher-menu-dark">
                <span
                  class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                  role="tooltip">
                  Dark Menu
                </span>
              </div>
              <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                <input class="hs-tooltip-toggle ti-form-radio color-input color-primary" type="radio" name="menu-colors"
                  id="switcher-menu-primary">
                <span
                  class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                  role="tooltip">
                  Color Menu
                </span>
              </div>
              <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                <input class="hs-tooltip-toggle ti-form-radio color-input color-gradient" type="radio" name="menu-colors"
                  id="switcher-menu-gradient">
                <span
                  class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                  role="tooltip">
                  Gradient Menu
                </span>
              </div>
              <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                <input class="hs-tooltip-toggle ti-form-radio color-input color-transparent" type="radio" name="menu-colors"
                  id="switcher-menu-transparent">
                <span
                  class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                  role="tooltip">
                  Transparent Menu
                </span>
              </div>
            </div>
            <div class="px-4 text-textmuted text-[.6875rem] !mb-3"><b class="me-2">Note:</b>If you want to change color Menu
              dynamically
              change from below Theme Primary color picker.</div>
          </div>
          <div class="theme-colors">
            <p class="switcher-style-head">Header Colors:</p>
            <div class="flex switcher-style space-x-3 rtl:space-x-reverse">
              <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                <input class="hs-tooltip-toggle ti-form-radio color-input color-white !border" type="radio" name="header-colors"
                  id="switcher-header-light" checked>
                <span
                  class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                  role="tooltip">
                  Light Header
                </span>
              </div>
              <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                <input class="hs-tooltip-toggle ti-form-radio color-input color-dark" type="radio" name="header-colors"
                  id="switcher-header-dark">
                <span
                  class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                  role="tooltip">
                  Dark Header
                </span>
              </div>
              <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                <input class="hs-tooltip-toggle ti-form-radio color-input color-primary" type="radio" name="header-colors"
                  id="switcher-header-primary">
                <span
                  class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                  role="tooltip">
                  Color Header
                </span>
              </div>
              <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                <input class="hs-tooltip-toggle ti-form-radio color-input color-gradient" type="radio" name="header-colors"
                  id="switcher-header-gradient">
                <span
                  class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                  role="tooltip">
                  Gradient Header
                </span>
              </div>
              <div class="hs-tooltip ti-main-tooltip ti-form-radio switch-select ">
                <input class="hs-tooltip-toggle ti-form-radio color-input color-transparent" type="radio"
                  name="header-colors" id="switcher-header-transparent">
                <span
                  class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-black text-xs font-medium !text-white shadow-sm dark:!bg-black"
                  role="tooltip">
                  Transparent Header
                </span>
              </div>
            </div>
            <div class="px-4 text-textmuted text-[.6875rem] !mb-3"><b class="me-2">Note:</b>If you want to change color
              Header dynamically
              change from below Theme Primary color picker.</div>
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
              <div class="ti-form-radio switch-select ps-0 mt-1 color-primary-light">
                <div class="theme-container-primary"></div>
                <div class="pickr-container-primary"></div>
              </div>
            </div>
          </div>
          <div class="theme-colors">
            <p class="switcher-style-head">Theme Background:</p>
            <div class="flex switcher-style space-x-3 rtl:space-x-reverse">
              <div class="ti-form-radio switch-select">
                <input class="ti-form-radio color-input color-background-1" type="radio" name="theme-background"
                  id="switcher-background" checked>
              </div>
              <div class="ti-form-radio switch-select">
                <input class="ti-form-radio color-input color-background-2" type="radio" name="theme-background"
                  id="switcher-background1">
              </div>
              <div class="ti-form-radio switch-select">
                <input class="ti-form-radio color-input color-background-3" type="radio" name="theme-background"
                  id="switcher-background2">
              </div>
              <div class="ti-form-radio switch-select">
                <input class="ti-form-radio color-input color-background-4" type="radio" name="theme-background"
                  id="switcher-background3">
              </div>
              <div class="ti-form-radio switch-select">
                <input class="ti-form-radio color-input color-background-5" type="radio" name="theme-background"
                  id="switcher-background4">
              </div>
              <div class="ti-form-radio switch-select ps-0 mt-1 color-bg-transparent">
                <div class="theme-container-background hidden"></div>
                <div class="pickr-container-background"></div>
              </div>
            </div>
          </div>
          <div class="menu-image theme-colors">
            <p class="switcher-style-head">Menu With Background Image:</p>
            <div class="flex switcher-style space-x-3 rtl:space-x-reverse flex-wrap gap-3">
              <div class="ti-form-radio switch-select">
                <input class="ti-form-radio bgimage-input bg-img1" type="radio" name="theme-images" id="switcher-bg-img">
              </div>
              <div class="ti-form-radio switch-select">
                <input class="ti-form-radio bgimage-input bg-img2" type="radio" name="theme-images" id="switcher-bg-img1">
              </div>
              <div class="ti-form-radio switch-select">
                <input class="ti-form-radio bgimage-input bg-img3" type="radio" name="theme-images" id="switcher-bg-img2">
              </div>
              <div class="ti-form-radio switch-select">
                <input class="ti-form-radio bgimage-input bg-img4" type="radio" name="theme-images" id="switcher-bg-img3">
              </div>
              <div class="ti-form-radio switch-select">
                <input class="ti-form-radio bgimage-input bg-img5" type="radio" name="theme-images" id="switcher-bg-img4">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ti-offcanvas-footer sm:flex justify-between">
        <a href="javascript:void(0);" id="reset-all" class="w-full ti-btn ti-btn-danger-full m-1">Reset</a>
      </div>
    </div>
    <!-- ========== END Switcher  ========== -->
  
    <!-- Loader -->
    <div id="loader" >
        <img src="{{ asset('backend/assets/images/media/loader.svg') }}" alt="">
    </div>
    <!-- Loader -->

    <style>
        @media (min-width: 992px) {
            .app-content {
                margin-inline-start: 240px;
                transition: margin-inline-start 0.3s ease;
            }
            [data-toggled="close-menu-close"] .app-content,
            [data-toggled="icon-text-close"] .app-content,
            [data-toggled="icon-overlay-close"] .app-content,
            [data-toggled="detached-close"] .app-content,
            [data-toggled="menu-click-closed"] .app-content,
            [data-toggled="menu-hover-closed"] .app-content,
            [data-toggled="icon-click-closed"] .app-content,
            [data-toggled="icon-hover-closed"] .app-content {
                margin-inline-start: 80px;
            }
            /* If sidebar is completely hidden by some toggle state, you might want 0, 
               but standard desktop toggle for Valex leaves icons visible (80px). */
        }
        .main-sidebar-header {
            transition: width 0.3s ease, padding 0.3s ease;
        }
    </style>
    <div class="page">
        @include('layouts.partials.valex.header')
        @include('layouts.partials.valex.sidebar')

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-[1.5rem] page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">@yield('page-title', 'Dashboard')</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">@yield('breadcrumb-parent', 'Home')</a></li>
                                <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb-child', 'Dashboard')</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                @yield('content')
            </div>
        </div>
        <!-- End::app-content -->

        <!-- Start::Off-canvas sidebar-->
        <div id="hs-overlay-chat" class="hs-overlay hidden ti-offcanvas ti-offcanvas-right overflow-auto" tabindex="-1">
          <div class="ti-offcanvas-header !py-2 rounded-none">
            <h5 class="text-[.875rem] uppercase mb-0 text-defaulttextcolor font-semibold" id="sidebarLabel">Notifications</h5>
            <button type="button"
              class="ti-btn flex-shrink-0 p-0  transition-none text-defaulttextcolor dark:text-defaulttextcolor/70 hover:text-gray-700 focus:ring-gray-400 focus:ring-offset-white  dark:hover:text-white/80 dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
              data-hs-overlay="#hs-overlay-chat">
              <span class="sr-only">Close modal</span>
              <i class="ri-close-fill leading-none text-lg"></i>
            </button>
          </div>
          <div class="ti-offcanvas-body rounded-none p-0">
            <ul class="nav nav-tabs  p-4" role="tablist">
              <div class=" rtl:space-x-reverse" aria-label="Tabs" role="tablist">
                <button type="button"
                  class="hs-tab-active:bg-primary w-full mb-2 rounded-[4px] !py-[10px] !px-[16px] text-start hs-tab-active:border-b-transparent text-defaultsize border-0 hs-tab-active:text-white dark:hs-tab-active:bg-primary dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-white  bg-light  font-semibold  text-defaulttextcolor dark:text-defaulttextcolor/70  hover:text-gray-700 dark:bg-bodybg2 dark:border-white/10  active"
                  id="chat-item" data-hs-tab="#chat" aria-controls="chat" role="tab">
                  <i class="fe fe-message-circle text-[.9375rem] me-2 inline-flex"></i>Chat
                </button>
                <button type="button"
                  class="hs-tab-active:bg-primary w-full mb-2  rounded-[4px] !py-[10px] !px-[16px] text-start hs-tab-active:border-b-transparent text-defaultsize border-0 hs-tab-active:text-white dark:hs-tab-active:bg-primary dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-white   bg-light font-semibold  text-defaulttextcolor dark:text-defaulttextcolor/70  hover:text-gray-700 dark:bg-bodybg2 dark:border-white/10  dark:hover:text-gray-300"
                  id="notification-item" data-hs-tab="#notification" aria-controls="notification" role="tab">
                  <i class="fe fe-bell text-[.9375rem] me-2 inline-flex"></i> Notifications
                </button>
                <button type="button"
                  class="hs-tab-active:bg-primary w-full mb-0 rounded-[4px] !py-[10px] !px-[16px] text-start hs-tab-active:border-b-transparent text-defaultsize border-0 hs-tab-active:text-white dark:hs-tab-active:bg-primary dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-white   bg-light font-semibold  text-defaulttextcolor dark:text-defaulttextcolor/70  hover:text-gray-700 dark:bg-bodybg2 dark:border-white/10  dark:hover:text-gray-300"
                  id="friends-item" data-hs-tab="#friends" aria-controls="friends" role="tab">
                  <i class="fe fe-users text-[.9375rem] me-2 inline-flex"></i>Friends
                </button>
              </div>
            </ul>
            <div class="tab-content !border-0 ">
              <div
                class="tab-pane !text-defaulttextcolor dark:text-defaulttextcolor/70 !border-s-0 !border-e-0 !rounded-none !p-0 show border-defaultborder dark:border-defaultborder/10 "
                id="chat" role="tabpanel" aria-labelledby="chat-item">
                <!-- Chat content items... -->
              </div>
              <div
                class="tab-pane !text-defaulttextcolor dark:text-defaulttextcolor/70 !border-s-0 !border-e-0 !rounded-none !p-0 border-defaultborder dark:border-defaultborder/10  hidden"
                id="notification" role="tabpanel" aria-labelledby="notification-item">
                <!-- Notification content items... -->
              </div>
              <div
                class="tab-pane !text-defaulttextcolor dark:text-defaulttextcolor/70 !border-s-0 !border-e-0 !rounded-none !p-0 border-defaultborder dark:border-defaultborder/10  hidden"
                id="friends" role="tabpanel" aria-labelledby="friends-item">
                <!-- Friends content items... -->
              </div>
            </div>
          </div>
        </div>
        <!-- End::Off-canvas sidebar-->

        <!-- Chat Modal placeholder -->
        <!-- Video Modal placeholder -->
        <!-- Audio Modal placeholder -->

        @include('layouts.partials.valex.footer')
    </div>

    @include('layouts.partials.valex.scripts')
</body>

</html>
