<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center fixed-top">
    <div id="header-container" class="container-fluid d-flex align-items-center justify-content-lg-between">
        <div class="d-flex align-items-center justify-content-lg-between gap-3">
            <img src="{{asset('/img/logo-transparent-background-120x120.webp')}}" width="45" height="45" alt="aero parking logo" class="rounded-5">
            <h2 class="logo me-auto me-lg-0">
                <a href="{{ App::getLocale() === 'sr' ? '/' : '/' . App::getLocale() }}">AERO PARKING</a>
            </h2>
        </div>

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a class="nav-link scrollto {{ Route::currentRouteName() === (App::getLocale() === 'sr' ? 'home' : App::getLocale() . '.home') ? 'active' : '' }}"
                       href="{{ App\Helpers\RouteHelper::localizedRoute('home') }}">
                        <i class="bi bi-house-door"></i>
                        <span>{{ __('messages.nav.home') }}</span>
                    </a></li>
                <li><a class="nav-link scrollto {{ Str::contains(Route::currentRouteName(), 'pricing') ? 'active' : '' }}"
                       href="{{ App\Helpers\RouteHelper::localizedRoute('pricing') }}">
                        <i class="bi bi-currency-exchange"></i>
                        <span>{{ __('messages.nav.pricing') }}</span>
                    </a></li>
                <li><a class="nav-link scrollto {{ Str::contains(Route::currentRouteName(), 'about') ? 'active' : '' }}"
                       href="{{ App\Helpers\RouteHelper::localizedRoute('about') }}">
                        <i class="bi bi-info-circle"></i>
                        <span>{{ __('messages.nav.about') }}</span>
                    </a></li>
                <li><a class="nav-link scrollto {{ Str::contains(Route::currentRouteName(), 'contact') ? 'active' : '' }}"
                       href="{{ App\Helpers\RouteHelper::localizedRoute('contact') }}">
                        <i class="bi bi-envelope"></i>
                        <span>{{ __('messages.nav.contact') }}</span>
                    </a></li>
                <li><a class="nav-link scrollto {{ Str::contains(Route::currentRouteName(), 'terms') ? 'active' : '' }}"
                       href="{{ App\Helpers\RouteHelper::localizedRoute('terms') }}">
                        <i class="bi bi-envelope"></i>
                        <span>{{ __('messages.nav.terms') }}</span>
                    </a></li>

                <!-- Mobile Language Switcher (only visible on mobile) -->
                @php
                    $currentLocale = App::getLocale();
                    $locales = [
                        'sr' => ['name' => 'SR', 'flag' => 'sr'],
                        'en' => ['name' => 'EN', 'flag' => 'en'],
                        'ru' => ['name' => 'RU', 'flag' => 'ru']
                    ];
                @endphp

                @foreach($locales as $code => $locale)
                    @if($code !== $currentLocale)
                        <li class="mobile-only-lang">
                            <a href="{{ App\Helpers\LocalizationHelper::getLocalizedUrl($code) }}"
                               class="lang-link-mobile"
                               hreflang="{{ $code }}">
                                <img src="{{ asset('img/flags/' . $locale['flag'] . '.svg') }}"
                                     alt="{{ $locale['name'] }}"
                                     class="flag-icon">
                                <span class="lang-code">{{ $locale['name'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>

            <!-- Enhanced Mobile Toggle -->
            <div class="mobile-nav-toggle">
                <span class="hamburger-line top"></span>
                <span class="hamburger-line middle"></span>
                <span class="hamburger-line bottom"></span>
            </div>
        </nav><!-- .navbar -->

        <div class="header-social-links d-none d-lg-flex align-items-center gap-3">
            @include('partials.common.language-switcher')
            <a href="https://www.facebook.com/parking.aero" class="facebook" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/parking.aero" class="instagram" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="tel:+381694454255" class="phone" aria-label="telephone"><i class="bi bi-telephone"></i></a>
        </div>
    </div>
</header><!-- End Header -->
