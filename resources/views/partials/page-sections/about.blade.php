<!-- ======= About Section ======= -->
<section id="onama" class="about">
    <div class="container">
        <div class="section-title">
            <h2>{{ __('messages.about.title') }}</h2>
        </div>
        <div class="row content">
            <div class="col-lg-8">
                <p>{!! __('messages.about.description') !!}</p>
            </div>
            <div class="col-lg-4 pt-4 pt-lg-0">
                <a href="{{ route('contact') }}" class="btn-learn-more">{{ __('messages.about.location_button') }}</a>
            </div>
        </div>
    </div>
</section><!-- End About Section -->
