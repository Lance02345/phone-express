<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed" data-theme-mode="light">

    <head>

        <!-- Meta Data -->
		<meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="@yield('meta_description', 'Shop smartphones at competitive prices from Phone Express Kenya, with flexible payment options and delivery across Kenya.')">
        <meta name="author" content="Phone Express Kenya">
        <meta name="theme-color" content="#123f2b">

        <!-- TITLE -->
		<title>@yield('title', 'Phone Express Kenya')</title>

        <!-- FAVICON -->
        <link rel="icon" href="{{ asset('Images/faviconapple.png') }}" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('Images/faviconapple.png') }}">

        <!-- BOOTSTRAP CSS -->
	    <link  id="style" href="{{asset('build/assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- ICONS CSS -->
        <link href="{{asset('build/assets/icon-fonts/icons.css')}}" rel="stylesheet">
        
        <!-- APP SCSS -->
        @vite(['resources/sass/app.scss'])

        <style>
            :root {
                --primary-color: #1a472a !important;
                --primary-light: #e8f5e9 !important;
                --primary-dark: #0a2e1a !important;
                --text-on-primary: #ffffff !important;
            }
            
            /* Override Bootstrap primary color globally */
            .btn-primary, 
            .bg-primary,
            .text-primary,
            .border-primary {
                background-color: var(--primary-color) !important;
                border-color: var(--primary-color) !important;
                color: var(--text-on-primary) !important;
            }
            
            .btn-primary:hover {
                background-color: var(--primary-dark) !important;
                border-color: var(--primary-dark) !important;
            }
            
            .btn-primary-light {
                background-color: var(--primary-light) !important;
                border-color: var(--primary-light) !important;
                color: var(--primary-color) !important;
            }
            
            .btn-primary-light:hover {
                background-color: #d4edda !important;
                border-color: #d4edda !important;
                color: var(--primary-dark) !important;
            }
            
            .text-primary {
                color: var(--primary-color) !important;
            }
            
            .bg-primary-transparent {
                background-color: rgba(26, 71, 42, 0.1) !important;
            }
            
            /* Landing banner */
            .landing-banner {
                background: linear-gradient(135deg, var(--primary-color) 0%, #2e7d32 100%) !important;
                padding-top: 100px !important;
            }
            
            .landing-footer {
                background-color: var(--primary-color) !important;
            }
            
            .bg-success {
                background-color: var(--primary-color) !important;
            }
            
            .text-success {
                color: var(--primary-color) !important;
            }
            
            .nav-tabs .nav-link.active {
                background-color: var(--primary-color) !important;
                border-color: var(--primary-color) !important;
                color: white !important;
            }
            
            .nav-tabs .nav-link {
                color: var(--primary-color) !important;
            }
            
            /* Sidebar styling */
            .app-sidebar {
                background: rgba(7, 37, 25, .92) !important;
                backdrop-filter: blur(22px) saturate(140%);
                border-bottom: 1px solid rgba(255,255,255,.08) !important;
                box-shadow: 0 12px 35px rgba(3, 25, 16, .12);
            }

            .landing-body .main-menu-container {
                min-height: 82px;
            }

            .landing-body .main-menu-container .main-menu {
                align-items: center;
                gap: .2rem;
            }

            .landing-body .app-sidebar .side-menu__item {
                position: relative;
                padding: .7rem .85rem !important;
                border-radius: 999px;
                transition: background-color .2s ease, color .2s ease, transform .2s ease;
            }

            .landing-body .app-sidebar .side-menu__label {
                color: rgba(255, 255, 255, .78) !important;
                font-weight: 600;
            }

            .landing-body .app-sidebar .side-menu__item.active,
            .landing-body .app-sidebar .side-menu__item:hover {
                background: rgba(255, 255, 255, .08) !important;
                transform: translateY(-1px);
            }

            .landing-body .app-sidebar .side-menu__item.active::after {
                content: '';
                position: absolute;
                right: 1rem;
                bottom: .35rem;
                left: 1rem;
                height: 2px;
                border-radius: 2px;
                background: #f3b33d;
            }

            .landing-body .app-sidebar .side-menu__item.active .side-menu__label,
            .landing-body .app-sidebar .side-menu__item:hover .side-menu__label {
                color: #ffffff !important;
            }

            .landing-nav-cta {
                display: inline-flex;
                align-items: center;
                gap: .45rem;
                margin-inline-start: 1rem;
                padding: .72rem 1rem;
                color: #172219;
                white-space: nowrap;
                background: #f3b33d;
                border-radius: 999px;
                box-shadow: 0 10px 24px rgba(243, 179, 61, .18);
                font-size: .82rem;
                font-weight: 800;
                text-decoration: none;
                transition: transform .2s ease, background-color .2s ease;
            }

            .landing-nav-cta:hover {
                color: #172219;
                background: #ffc85a;
                transform: translateY(-2px);
            }
            
            .slide-left, .slide-right {
                color: #ffffff !important;
            }
            
            /* Header styling */
            .app-header {
                background-color: rgba(11, 44, 30, .98) !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            }
            
            .header-link {
                color: #ffffff !important;
            }
            
            .header-link:hover {
                color: var(--primary-light) !important;
            }
            
            /* Footer styling */
            .landing-main-footer {
                background-color: var(--primary-dark) !important;
                color: #ffffff !important;
            }
            
            .landing-main-footer .text-primary {
                color: #e8f5e9 !important;
            }
            
            .landing-section-heading {
                color: var(--primary-color) !important;
            }
            
            /* Hero section text improvements */
            .landing-banner-heading {
                font-size: 3.5rem;
                font-weight: 700;
                line-height: 1.1;
                color: #ffffff;
                margin-bottom: 1.5rem;
            }
            
            .text-fixed-white {
                color: #ffffff !important;
            }
            
            .text-secondary {
                color: #e8f5e9 !important;
            }
            
            .op-7 {
                opacity: 0.9 !important;
            }
            
            .op-9 {
                opacity: 1 !important;
            }
            
            /* Ensure good contrast in hero section */
            .landing-banner .fs-16 {
                font-size: 1.1rem;
                line-height: 1.6;
                color: rgba(255, 255, 255, 0.95);
            }
            
            /* Categories Section Styles */
            .category-card {
                transition: all 0.3s ease;
                border: none;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                height: 100%;
            }
            
            .category-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 15px rgba(0,0,0,0.15);
            }
            
            .category-icon {
                font-size: 3rem;
                color: var(--primary-color);
                margin-bottom: 1rem;
            }
            
            .category-count {
                background-color: var(--primary-color);
                color: white;
                border-radius: 15px;
                padding: 0.25rem 0.75rem;
                font-size: 0.8rem;
                font-weight: 600;
            }
            
            /* Responsive font sizes */
            @media (max-width: 768px) {
                .landing-banner-heading {
                    font-size: 2.5rem;
                }
                
                .landing-banner .fs-16 {
                    font-size: 1rem;
                }
                
                .category-icon {
                    font-size: 2.5rem;
                }
                
                .app-sidebar {
                    width: 250px !important;
                }

                .landing-nav-cta {
                    display: none;
                }
            }

            @media (max-width: 991.98px) {
                .landing-nav-cta { display: none; }
            }
        </style>

        @include('layouts.components.landing.styles')
        @yield('styles')

	</head>

    <body class="landing-body">

        <!-- PAGE -->
		<div class="landing-page-wrapper">

            <!-- HEADER -->
            @include('layouts.components.landing.header')
            <!-- END HEADER -->

            <!-- SIDEBAR -->
            @include('layouts.components.landing.sidebar')
            <!-- END SIDEBAR -->

            <!-- MAIN-CONTENT -->
            <div class="main-content landing-main">
                @yield('content')
                
                <!-- FOOTER -->
                @include('layouts.components.landing.footer')
                <!-- FOOTER -->
            </div> 
            <!-- END MAIN-CONTENT -->

		</div>
        <!-- END PAGE-->

        <!-- SCRIPTS -->
        @include('layouts.components.landing.scripts')
        @yield('scripts')
        
        <!-- STICKY JS -->
		<script src="{{asset('build/assets/sticky.js')}}"></script>

        <script>
            // Smooth scroll for navigation links
            document.addEventListener('DOMContentLoaded', function() {
                // Add smooth scrolling to all links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });
                
                // Update copyright year
                document.getElementById('year').textContent = new Date().getFullYear();
            });
        </script>

	</body>
</html>
