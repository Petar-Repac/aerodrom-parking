<!DOCTYPE html>
<html lang="sr">
@include('partials.head.head')
<body>


<!-- ======= Header ======= -->
@include('partials.common.header')

<main id="main">
    @include('partials.page-sections.pricing')
    @include('partials.page-sections.cta')
    @foreach($articles as $article)
        <h1>{{$article['Title']}}</h1>
    @endforeach
</main><!-- End #main -->

@include('partials.common.footer')

@include('partials.common.reservation-drawer')

@include('partials.common.scripts-homepage')
</body>

</html>
