<!DOCTYPE html>
<html lang="sr">
@include('partials.head.head')
<meta name="google-site-verification" content="TlOiA-UltrkvBlDJa9cYqfdlcdnzJZs6WyFG3XTDyI0" />
<body>

@include('partials.page-sections.hero')

<!-- ======= Header ======= -->
@include('partials.common.header')

<main id="main">

    @include('partials.page-sections.parking-instructions')
    @include('partials.page-sections.pricing')
    @include('partials.page-sections.services')
    @include('partials.page-sections.counts')
    @include('partials.page-sections.cta')
    @include('partials.page-sections.about')
    @include('partials.page-sections.contact')

</main><!-- End #main -->

@include('partials.common.footer')

@include('partials.common.reservation-drawer')

@include('partials.common.scripts-homepage')

{{--@include('partials.util.theme-customizer')--}}
</body>

</html>
