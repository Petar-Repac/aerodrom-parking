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
                <!-- ======= Page not found Section ======= -->
                <section id="cta" class="cta">
                    <div class="container">
                        <div class="text-center">
                            <h3>{{ __('messages.page_not_found.title') }}</h3>
                            <p>{{ __('messages.page_not_found.description') }}</p>
                            <a class="cta-btn" href="{{ App\Helpers\RouteHelper::localizedRoute('home') }}">
                                {{ __('messages.page_not_found.back_home') }}
                            </a>
                        </div>
                    </div>
                </section><!-- End Page not found Section -->

            </div>
        </div>
    </section><!-- End About Section -->



</main><!-- End #main -->

@include('partials.common.footer')

@include('partials.common.scripts-homepage')

{{--@include('partials.util.theme-customizer')--}}
</body>

</html>
