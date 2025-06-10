<!DOCTYPE html>
<html lang="sr">
@include('partials.head.head')
<body>

<!-- ======= Header ======= -->
@include('partials.common.header')

<main id="main">

    <!-- ======= About Section ======= -->
    <section id="onama" class="about">
        <div class="container">
            <div class="section-title">
                <h2>Stranica nije pronađena!</h2>
            </div>
            <div class="row content">
                <div class="col-lg-8">
                    <p></p>
                </div>
            </div>
        </div>
    </section><!-- End About Section -->


    @include('partials.page-sections.cta')

</main><!-- End #main -->

@include('partials.common.footer')

@include('partials.common.reservation-drawer')

@include('partials.common.scripts-homepage')

{{--@include('partials.util.theme-customizer')--}}
</body>

</html>
