<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Meta -->
    <title>{{ __('messages.meta.title') }}</title>

    <!-- Favicons -->
    <link href="{{asset('img/android-chrome-512x512.png')}}" rel="icon">

    @php
        $alternateUrls = App\Helpers\LocalizationHelper::getAlternateUrls();
    @endphp

        <!-- Hreflang Tags -->
    <link rel="alternate" hreflang="sr" href="{{ $alternateUrls['sr'] }}" />
    <link rel="alternate" hreflang="en" href="{{ $alternateUrls['en'] }}" />
    <link rel="alternate" hreflang="ru" href="{{ $alternateUrls['ru'] }}" />
    <link rel="alternate" hreflang="x-default" href="{{ $alternateUrls['sr'] }}" />

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ __('messages.meta.title') }}">
    <meta property="og:image" content="{{asset('img/android-chrome-512x512.png')}}">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Aero Parking">
    <meta property="og:description" content="{{ __('messages.meta.description') }}">
    <meta property="og:locale" content="{{ App::getLocale() === 'sr' ? 'sr_RS' : (App::getLocale() === 'en' ? 'en_US' : 'ru_RU') }}">

    <!-- Additional meta tags -->
    <meta name="description" content="{{ __('messages.meta.description') }}">
    <meta name="keywords" content="{{ __('messages.meta.keywords') }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ __('messages.meta.title') }}">
    <meta name="twitter:description" content="{{ __('messages.meta.description') }}">
    <meta name="twitter:image" content="{{asset('img/android-chrome-512x512.png')}}">

    <!-- Additional SEO Meta Tags -->
    <meta name="robots" content="index, follow">
    <meta name="author" content="Aero Parking">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Eager loaded css -->
    <link rel="stylesheet" href="{{asset("google-fonts/google-fonts.css")}}">
    <link rel="stylesheet" href="{{asset("vendor/bootstrap/css/bootstrap.optimized.min.css")}}">
    <link rel="stylesheet" href="{{asset("vendor/bootstrap-icons/bootstrap-icons.optimized.min.css") . "?" . env('APP_VERSION')}} ">
    <link rel="stylesheet" href="{{asset("vendor/boxicons/css/boxicons.optimized.min.css")}}">
    <link rel="stylesheet" href="{{asset("vendor/remixicon/remixicon.optimized.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/fontawesome-optimized.min.css") . "?" . env('APP_VERSION')}}">
    <link rel="stylesheet" href="{{asset("css/style.css") . "?" . env('APP_VERSION')}}">
    <link rel="stylesheet" href="{{asset("vendor/flatpickr/css/dark.css")}}">
    <link rel="stylesheet" href="{{asset("vendor/flatpickr/css/theme-override.css")}}">

    <!-- Deferred css -->
    <link rel="preload" href="{{asset('vendor/glightbox/css/glightbox.min.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{asset('vendor/glightbox/css/glightbox.min.css')}}"></noscript>
    <link rel="preload" href="{{asset('vendor/swiper/swiper-bundle.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{asset('vendor/swiper/swiper-bundle.css')}}"></noscript>

    <script>
        window.appLocale = '{{ App::getLocale() }}';
        window.translations = @json(__('js'));
    </script>

    @include('partials.head.google-analytics')

    @include('partials.head.json-ld')

    @include('partials.util.colour-switcher')

    <meta name="google-site-verification" content="TlOiA-UltrkvBlDJa9cYqfdlcdnzJZs6WyFG3XTDyI0" />

</head>
