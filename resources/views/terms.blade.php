<!DOCTYPE html>
<html lang="sr">
@include('partials.head.head')
<body>

<!-- ======= Header ======= -->
@include('partials.common.header')

<main id="main">

    <!-- ======= Terms & Conditions Section ======= -->
    <section id="terms" class="about mt-4">
        <div class="container">
            <div class="section-title">
                <h2>{{ __('messages.terms.title') }}</h2>
            </div>
            <div class="row content">
                <div class="col-lg-12">
                    <p>{!! __('messages.terms.intro') !!}</p>

                    <h3>{{ __('messages.terms.section_1.title') }}</h3>
                    <p>{!! __('messages.terms.section_1.content') !!}</p>

                    <h3>{{ __('messages.terms.section_2.title') }}</h3>
                    <p>{!! __('messages.terms.section_2.content') !!}</p>

                    <h3>{{ __('messages.terms.section_3.title') }}</h3>
                    <p>{!! __('messages.terms.section_3.content') !!}</p>

                    <h3>{{ __('messages.terms.section_4.title') }}</h3>
                    <p>{!! __('messages.terms.section_4.content') !!}</p>

                    <h3>{{ __('messages.terms.section_5.title') }}</h3>
                    <p>{!! __('messages.terms.section_5.content') !!}</p>

                    <h3>{{ __('messages.terms.section_6.title') }}</h3>
                    <p>{!! __('messages.terms.section_6.content') !!}</p>

                    <p><em>{!! __('messages.terms.closing') !!}</em></p>
                </div>
            </div>
        </div>
    </section><!-- End Terms & Conditions Section -->

    @include('partials.page-sections.cta')

</main><!-- End #main -->

@include('partials.common.footer')

@include('partials.common.reservation-drawer')

@include('partials.common.scripts-homepage')

</body>

</html>
