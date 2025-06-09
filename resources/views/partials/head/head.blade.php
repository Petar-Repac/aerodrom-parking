
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">


    <!-- Meta -->
    <title>Aero Parking | Najpovoljniji parking na aerodromu Nikola Tesla</title>
    <meta name="description" content="Aero Parking – Siguran i povoljan parking nadomak Aerodroma Beograd. Najpovoljniji parking, 24/7 nadzor i besplatan transfer do terminala. Rezervišite online!">
    <meta content="parking aerodrom nikola tesla" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('img/android-chrome-512x512.png')}}" rel="icon">

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
