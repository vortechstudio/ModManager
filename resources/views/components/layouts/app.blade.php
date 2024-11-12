<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
        @vite('resources/css/app.css')
        @livewireStyles
    </head>
    <body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <!--begin::Theme mode setup on page load-->
    <script>
        let defaultThemeMode = "light";
        let themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }</script>
    <!--end::Theme mode setup on page load-->
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: false, lg: true}" data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: false, lg: '300px'}">
                <!--begin::Header container-->
                <div class="app-container container-xxl d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
                    <!--begin::Header mobile toggle-->
                    <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_header_menu_toggle">
                            <i class="ki-outline ki-abstract-14 fs-2"></i>
                        </div>
                    </div>
                    <!--end::Header mobile toggle-->
                    <!--begin::Logo-->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-18">
                        <a href="{{ route('home') }}">
                            <span class="text-white fs-2 fw-bold">MOD MANAGER</span>
                        </a>
                    </div>
                    <!--end::Logo-->
                    <!--begin::Header wrapper-->
                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
                        <!--begin::Menu wrapper-->
                        <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-active-bg menu-state-primary menu-column menu-lg-row menu-title-gray-700 menu-icon-gray-500 menu-arrow-gray-500 menu-bullet-gray-500 my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
                                <!--begin:Menu item-->
                                <div class="menu-item {{ Route::is('home') ? 'here' : '' }}">
                                    <a class="menu-link" href="{{ route('home') }}" wire:navigate>
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-home fs-2"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">Tableau de Bord</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="" wire:navigate>
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-plus-circle fs-2"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">Nouveau Mod</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="" wire:navigate>
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-pencil fs-2"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">Edition de Mod</span>
                                    </a>
                                </div>
                                <div class="menu-item {{ Route::is('configuration') ? 'here' : '' }}">
                                    <a class="menu-link" href="{{ route('configuration') }}" wire:navigate>
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-setting fs-2"><span class="path1"></span><span class="path2"></span></i>
                                        </span>
                                        <span class="menu-title">Configuration</span>
                                    </a>
                                </div>
                                <!--end:Menu item-->
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu wrapper-->
                        <!--begin::Navbar-->
                        <div class="app-navbar flex-shrink-0">
                            <!--begin::Quick links-->
                            @livewire('core.check-config-system')
                        </div>
                        <!--end::Navbar-->
                    </div>
                    <!--end::Header wrapper-->
                </div>
                <!--end::Header container-->
            </div>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Toolbar-->
                <div id="kt_app_toolbar" class="app-toolbar py-6">
                    <!--begin::Toolbar container-->
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-start">
                        <!--begin::Toolbar container-->
                        <div class="d-flex flex-column flex-row-fluid">
                            <!--begin::Toolbar wrapper-->
                            <div class="d-flex align-items-center pt-1">
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-white fw-bold lh-1">
                                        <a href="index.html" class="text-white text-hover-primary">
                                            <i class="ki-outline ki-home text-gray-700 fs-6"></i>
                                        </a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item">
                                        <i class="ki-outline ki-right fs-7 text-gray-700 mx-n1"></i>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-white fw-bold lh-1">Dashboards</li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Toolbar wrapper=-->
                            <!--begin::Toolbar wrapper=-->
                            <div class="d-flex flex-stack flex-wrap flex-lg-nowrap gap-4 gap-lg-10 pt-13 pb-6">
                                <!--begin::Page title-->
                                <div class="page-title me-5">
                                    <!--begin::Title-->
                                    <h1 class="page-heading d-flex text-white fw-bold fs-2 flex-column justify-content-center my-0">Bonjour, {{ get_current_user() }}
                                        <!--begin::Description-->
                                        <!--end::Description--></h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Page title-->
                            </div>
                            <!--end::Toolbar wrapper=-->
                        </div>
                        <!--end::Toolbar container=-->
                    </div>
                    <!--end::Toolbar container-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Wrapper container-->
                <div class="app-container container-xxl">
                    <!--begin::Main-->
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <!--begin::Content wrapper-->
                        <div class="d-flex flex-column flex-column-fluid">
                            <!--begin::Content-->
                            <div id="kt_app_content" class="app-content flex-column-fluid">
                                {{ $slot }}
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Content wrapper-->
                        <!--begin::Footer-->
                        <div id="kt_app_footer" class="app-footer d-flex flex-column flex-md-row align-items-center flex-center flex-md-stack py-2 py-lg-4">
                            <!--begin::Copyright-->
                            <div class="text-gray-900 order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">2024&copy;</span>
                                <a href="" target="_blank" class="text-gray-800 text-hover-primary">TPF France</a>
                            </div>
                            <!--end::Copyright-->
                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end:::Main-->
                </div>
                <!--end::Wrapper container-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->
    <!--begin::Drawers-->

    <!--end::Drawers-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-outline ki-arrow-up"></i>
    </div>
    <!--end::Scrolltop-->
    <!--begin::Modals-->
    <!--end::Modals-->
    <!--begin::Javascript-->
    <script>let hostUrl = "assets/";</script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    @vite('resources/js/app.js')
    @livewireScripts
    @yield("scripts")
    <!--end::Global Javascript Bundle-->
    <!--end::Javascript-->
    </body>
</html>
