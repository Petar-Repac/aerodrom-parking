<!-- ======= Hero Section ======= -->
<section id="pocetna">
    <div class="pocetna-container">
        <h1>{{ __('messages.hero.title') }}</h1>
        <h2>{{ __('messages.hero.subtitle') }}</h2>

        <div id="reservation-landing">
            <div class="date-inputs">
                <div class="date-input-container">
                    <input id="cta-arrival-date"
                           name="arrival-date"
                           placeholder="{{ __('messages.hero.arrival_date') }}">
                </div>
                <div class="separator"></div>
                <div class="date-input-container">
                    <input id="cta-departure-date"
                           name="departure-date"
                           placeholder="{{ __('messages.hero.departure_date') }}">
                </div>
            </div>

            <div id="cta-landing">
                <span>{{ __('messages.hero.reserve_button') }}</span>
                <span class="divider"></span>
                <span id="cta-charge">{{ __('messages.hero.price') }}</span>
            </div>
        </div>
    </div>
</section><!-- End Hero -->
