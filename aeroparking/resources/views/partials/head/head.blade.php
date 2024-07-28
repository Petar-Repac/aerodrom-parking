
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Aero Parking | Najniže cene parkinga na aerodromu Nikola Tesla</title>
    <meta content='Aero Parking je uslužni parking na 2 minuta od aerodroma Nikola Tesla. Najpovoljnije cene i sezonske akcije do 50%. Gratis transfer u oba smera. +381 69 445 4255' name="description">
    <meta content="parking aerodrom nikola tesla" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('img/android-chrome-512x512.png')}}" rel="icon">

    <!-- Eager loaded css -->
    @vite([
        'public/google-fonts/google-fonts.css',
        'public/vendor/bootstrap/css/bootstrap.optimized.min.css',
        'public/vendor/bootstrap-icons/bootstrap-icons.optimized.min.css',
        'public/vendor/boxicons/css/boxicons.optimized.min.css',
        'public/vendor/remixicon/remixicon.optimized.min.css',
        'public/css/fontawesome-optimized.min.css',
        'public/css/style.css',
    ])

    <!-- Deferred css -->
    <link rel="preload" href="{{Vite::asset('public/vendor/glightbox/css/glightbox.min.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{Vite::asset('public/vendor/glightbox/css/glightbox.min.css')}}"></noscript>
    <link rel="preload" href="{{Vite::asset('public/vendor/swiper/swiper-bundle.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{Vite::asset('public/vendor/swiper/swiper-bundle.css')}}"></noscript>


    @include('partials.head.google-analytics')

    @include('partials.head.json-ld')
</head>
