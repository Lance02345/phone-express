<aside class="app-sidebar sticky" id="sidebar">
    <div class="container-xl">
        <!-- Start::main-sidebar -->
        <div class="main-sidebar">
            <!-- Start::nav -->
            <nav class="main-menu-container nav nav-pills sub-open">
                <div class="landing-logo-container">
                    <div class="horizontal-logo">
                        <a href="{{ route('home') }}" class="header-logo" aria-label="Phone Express home">
                            <img src="{{ asset('Images/logo-header2.png') }}" alt="Phone Express Kenya" class="desktop-logo"
                                style="width:190px; height:auto;">
                            <img src="{{ asset('Images/logo-header2.png') }}" alt="Phone Express Kenya" class="desktop-white"
                                style="width:190px; height:auto;">
                        </a>
                    </div>
                </div>

                <div class="slide-left" id="slide-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                    </svg>
                </div>
                
                <ul class="main-menu">
                    <!-- Start::slide -->
                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}#home" data-nav-section="home">
                            <span class="side-menu__label">Home</span>
                        </a>
                    </li>
                    
                    <li class="slide">
                        <a href="{{ route('home') }}#categories" class="side-menu__item" data-nav-section="categories">
                            <span class="side-menu__label">Categories</span>
                        </a>
                    </li>
                    
                    <li class="slide">
                        <a href="{{ route('pricing') }}" class="side-menu__item {{ request()->routeIs('pricing', 'phones.show') ? 'active' : '' }}">
                            <span class="side-menu__label">Shop</span>
                        </a>
                    </li>
                    
                    <li class="slide">
                        <a href="{{ route('home') }}#about" class="side-menu__item" data-nav-section="about">
                            <span class="side-menu__label">About</span>
                        </a>
                    </li>
                    
                    <li class="slide">
                        <a href="{{ route('home') }}#testimonials" class="side-menu__item" data-nav-section="testimonials">
                            <span class="side-menu__label">Clients</span>
                        </a>
                    </li>
                    
                    <li class="slide">
                        <a href="{{ route('home') }}#faq" class="side-menu__item" data-nav-section="faq">
                            <span class="side-menu__label">FAQ's</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a href="{{ route('policies.index') }}" class="side-menu__item {{ request()->routeIs('policies.*') ? 'active' : '' }}">
                            <span class="side-menu__label">Shopping help</span>
                        </a>
                    </li>
                    
                    <li class="slide">
                        <a href="{{ route('home') }}#contact" class="side-menu__item" data-nav-section="contact">
                            <span class="side-menu__label">Contact</span>
                        </a>
                    </li>
                </ul>

                <a href="{{ route('pricing') }}" class="landing-nav-cta">
                    Shop phones <i class="ri-arrow-right-line"></i>
                </a>
                
                <div class="slide-right" id="slide-right">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                    </svg>
                </div>
            </nav>
            <!-- End::nav -->
        </div>
        <!-- End::main-sidebar -->
    </div>
</aside>
