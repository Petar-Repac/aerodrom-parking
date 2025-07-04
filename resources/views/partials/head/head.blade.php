
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">


    <!-- Meta -->
    <title>Aero Parking | Najpovoljniji parking na aerodromu Nikola Tesla</title>

    <!-- Favicons -->
    <link href="{{asset('img/android-chrome-512x512.png')}}" rel="icon">

    <!-- Open Graph Meta Tags for Aero Parking -->
    <meta property="og:title" content="Aero Parking | Najpovoljniji parking na aerodromu Nikola Tesla">
    <meta property="og:image" content="{{asset('img/android-chrome-512x512.png')}}">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:url" content="https://aeroparking.rs/">
    <meta property="og:site_name" content="Aero Parking">
    <meta property="og:description" content="Aero Parking – Siguran i povoljan parking nadomak Aerodroma Beograd. Najpovoljniji parking, 24/7 nadzor i besplatan transfer do terminala. Rezervišite online!">
    <meta property="og:locale" content="sr_RS">

    <!-- Additional meta tags -->
    <meta name="description" content="Aero Parking – Siguran i povoljan parking nadomak Aerodroma Beograd. Najpovoljniji parking, 24/7 nadzor i besplatan transfer do terminala. Rezervišite online!">
    <meta name="keywords" content="parking aerodrom, Nikola Tesla aerodrom, parking Beograd, transfer aerodrom, jeftin parking, rezervacija parking">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Aero Parking | Najpovoljniji parking na aerodromu Nikola Tesla">
    <meta name="twitter:description" content="Aero Parking – Siguran i povoljan parking nadomak Aerodroma Beograd. Najpovoljniji parking, 24/7 nadzor i besplatan transfer do terminala. Rezervišite online!">
    <meta name="twitter:image" content="{{asset('img/android-chrome-512x512.png')}}">

    <!-- Additional SEO Meta Tags -->
    <meta name="robots" content="index, follow">
    <meta name="author" content="Aero Parking">
    <link rel="canonical" href="https://aeroparking.rs/">

    <!-- Eager loaded css -->
    <link rel="stylesheet" href="{{asset("google-fonts/google-fonts.css")}}">
    <link rel="stylesheet" href="{{asset("vendor/bootstrap/css/bootstrap.optimized.min.css")}}">
    <link rel="stylesheet" href="{{asset("vendor/bootstrap-icons/bootstrap-icons.optimized.min.css") . "?" . env('APP_VERSION')}} ">
    <link rel="stylesheet" href="{{asset("vendor/boxicons/css/boxicons.optimized.min.css")}}">
    <link rel="stylesheet" href="{{asset("vendor/remixicon/remixicon.optimized.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/fontawesome-optimized.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/style.css") . "?" . env('APP_VERSION')}}">

    <!-- Deferred css -->
    <link rel="preload" href="{{asset('vendor/glightbox/css/glightbox.min.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{asset('vendor/glightbox/css/glightbox.min.css')}}"></noscript>
    <link rel="preload" href="{{asset('vendor/swiper/swiper-bundle.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{asset('vendor/swiper/swiper-bundle.css')}}"></noscript>

    @include('partials.head.google-analytics')

    @include('partials.head.json-ld')

    @include('partials.util.colour-switcher')


</head>
