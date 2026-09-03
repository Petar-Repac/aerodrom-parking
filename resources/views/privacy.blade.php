<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('partials.head.head')
<body>

<!-- ======= Header ======= -->
@include('partials.common.header')

<main id="main">

    <!-- ======= Privacy Policy Section ======= -->
    <section id="privacy" class="about mt-4">
        <div class="container">
            <div class="section-title">
                <h2>{{ __('messages.privacy.title') }}</h2>
            </div>
            <div class="row content">
                <div class="col-lg-12">
                    <p>{!! __('messages.privacy.intro') !!}</p>

                    <h3>{{ __('messages.privacy.section_1.title') }}</h3>
                    <p>{!! __('messages.privacy.section_1.content') !!}</p>

                    <h3>{{ __('messages.privacy.section_2.title') }}</h3>
                    <p>{!! __('messages.privacy.section_2.content') !!}</p>

                    <h3>{{ __('messages.privacy.section_3.title') }}</h3>
                    <p>{!! __('messages.privacy.section_3.content') !!}</p>

                    <h3>{{ __('messages.privacy.section_4.title') }}</h3>
                    <p>{!! __('messages.privacy.section_4.content') !!}</p>

                    <h3>{{ __('messages.privacy.section_5.title') }}</h3>
                    <p>{!! __('messages.privacy.section_5.content') !!}</p>

                    <h3>{{ __('messages.privacy.section_6.title') }}</h3>
                    <p>{!! __('messages.privacy.section_6.content') !!}</p>

                    <p><em>{!! __('messages.privacy.closing') !!}</em></p>
                </div>
            </div>
        </div>
    </section><!-- End Privacy Policy Section -->

    @include('partials.page-sections.cta')

</main><!-- End #main -->

@include('partials.common.footer')

@include('partials.common.reservation-drawer')

@include('partials.common.scripts-homepage')

</body>

</html>
