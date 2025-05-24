<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center fixed-top">
    <div id="header-container" class="container-fluid d-flex align-items-center justify-content-lg-between">
        <div class="d-flex align-items-center justify-content-lg-between gap-3">
            <img src="/img/logo-transparent-background-120x120.webp" width="45" height="45" alt="aero parking logo" class="rounded-5">
            <h2 class="logo me-auto me-lg-0">
                <a href="/">AERO PARKING</a>
            </h2>
        </div>

        @php
            $theme = request()->query('theme');
        @endphp

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a class="nav-link scrollto {{ request()->is('/')  ? 'active' : '' }}" href="/?theme={{$theme}}">
                        <i class="bi bi-house-door"></i>
                        <span>Početna</span>
                    </a></li>
                <li><a class="nav-link scrollto {{ request()->is('pricing')  ? 'active' : '' }}" href="/pricing?theme={{$theme}}">
                        <i class="bi bi-currency-exchange"></i>
                        <span>Cenovnik</span>
                    </a></li>
                <li><a class="nav-link scrollto {{ request()->is('about-us')  ? 'active' : '' }}" href="/about-us?theme={{$theme}}">
                        <i class="bi bi-info-circle"></i>
                        <span>O nama</span>
                    </a></li>
                <li><a class="nav-link scrollto {{ request()->is('contact')  ? 'active' : '' }}" href="/contact?theme={{$theme}}">
                        <i class="bi bi-envelope"></i>
                        <span>Kontakt</span>
                    </a></li>
            </ul>

            <!-- Enhanced Mobile Toggle - REPLACE any old <i class="bi bi-list mobile-nav-toggle"></i> -->
            <div class="mobile-nav-toggle">
                <span class="hamburger-line top"></span>
                <span class="hamburger-line middle"></span>
                <span class="hamburger-line bottom"></span>
            </div>
        </nav><!-- .navbar -->

        <div class="header-social-links d-none d-lg-flex align-items-center">
            <a href="https://www.facebook.com/parking.aero" class="facebook" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/parking.aero" class="instagram" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="tel:0694454255" class="phone" aria-label="telephone"><i class="bi bi-telephone"></i></a>
        </div>
    </div>
</header><!-- End Header -->
