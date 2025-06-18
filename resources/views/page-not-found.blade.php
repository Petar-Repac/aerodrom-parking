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
            <div class="section-title" style="margin-top: 200px;">
            </div>
            <div class="row content">
                <!-- ======= Cta Section ======= -->
                <section id="cta" class="cta">
                    <div class="container">

                        <div class="text-center">
                            <h3>Stranica nije pronađena!</h3>
                            <p>
                                Sadržaj koji tražite je možda uklonjen, ili se ne nalazi na ovoj lokaciji.
                            </p>
                            <a class="cta-btn"  href="/">Povratak na početnu</a>
                        </div>
                    </div>
                </section><!-- End Cta Section -->

            </div>
        </div>
    </section><!-- End About Section -->



</main><!-- End #main -->

@include('partials.common.footer')

@include('partials.common.scripts-homepage')

{{--@include('partials.util.theme-customizer')--}}
</body>

</html>
