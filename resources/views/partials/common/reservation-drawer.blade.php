<a id="reserve-btn" class="pulse contact-links-toggle"><i class="bi bi-telephone"></i> {{ __('messages.contact_btn') }}</a>

<!-- Contact links -->
<nav id="contact-links">
    <i class="contact-links-close bi bi-x"></i>

    <ul>
        <li id="cta-reserve">
            <span>
                <i class="fa fa-calendar-check"></i>
                {{ __('messages.contact_links.online_reservation') }}
            </span>
        </li>

        <li><a href="https://wa.me/+381694454255">
                <i class="fab fa-whatsapp"></i>
                {{ __('messages.contact_links.whatsapp') }}
            </a>
        </li>
        <li>
            <a target="_blank" href="viber://chat?number=%2B381694454255">
                <i class="fab fa-viber"></i>
                {{ __('messages.contact_links.viber') }}
            </a>
        </li>
        <li>
            <a href="mailto:rezervacije@aeroparking.rs">
                <i class="fa fa-envelope" aria-label="Rezervacija"></i>
                {{ __('messages.contact_links.email') }}
            </a>
        </li>
        <li>
            <a href="tel:0694454255">
                <i class="fa fa-phone"></i>
                {{ __('messages.contact_links.call_us') }}
            </a>
        </li>
    </ul>

</nav><!-- .navbar -->


<!-- Contact links -->
<!-- Reservation Form -->
<section id="reservation-form">
    <i class="close bi bi-x"></i>
    <section id="contact" class="contact">
        <div class="row mt-2 pb-2">
            <div class="d-flex align-items-center justify-content-lg-center gap-3 p-1 logo">
                <h2 class="me-auto me-lg-0 text-center">{{ __('messages.reservation_form.title') }}</h2>
            </div>

            <form id="email-form" class="reservation-form-content">

                <div class="col-lg-12 mt-5 mt-lg-0">
                    <div class="form-section">
                        <h4><i class="bi bi-person-circle"></i> {{ __('messages.reservation_form.personal_data') }}</h4>
                        <div class="contact-info">
                            <div class="input-group">
                                <i class="bi bi-person input-icon"></i>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control styled-input"
                                    id="name"
                                    placeholder="{{ __('messages.reservation_form.name') }}"
                                    required
                                />
                            </div>

                            <div class="input-group">
                                <i class="bi bi-envelope input-icon"></i>
                                <input
                                    type="email"
                                    class="form-control styled-input"
                                    name="email"
                                    id="email"
                                    placeholder="{{ __('messages.reservation_form.email') }}"
                                />
                            </div>

                            <div class="input-group">
                                <i class="bi bi-telephone input-icon"></i>
                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control styled-input"
                                    id="phone"
                                    placeholder="{{ __('messages.reservation_form.phone') }}"
                                    required
                                />
                            </div>

                            <div class="input-group">
                                <i class="bi bi-people input-icon"></i>
                                <input
                                    type="number"
                                    class="form-control styled-input"
                                    name="passengers"
                                    id="passengers"
                                    placeholder="{{ __('messages.reservation_form.passengers') }}"
                                    min="1"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    <div class="form-section">
                        <h4><i class="bi bi-calendar-event"></i> {{ __('messages.reservation_form.time') }}</h4>
                        <div class="date-inputs">
                            <div class="date-input-container">
                                <div class="input-group">
                                    <i class="bi bi-calendar-plus input-icon"></i>
                                    <input
                                        type="text"
                                        id="arrival-date"
                                        name="arrival-date"
                                        class="date-picker styled-input"
                                        placeholder="{{ __('messages.reservation_form.arrival_date') }}"
                                        required
                                    />
                                </div>
                                <div class="input-group">
                                    <i class="bi bi-alarm input-icon"></i>
                                    <select
                                        id="arrival-time"
                                        name="arrival-time"
                                        class="time-select styled-input"
                                        required
                                    >
                                        <option value="" disabled selected>{{ __('messages.reservation_form.arrival_time') }}</option>
                                        @for ($h = 0; $h < 24; $h++)
                                            @foreach ([0, 30] as $m)
                                                @php($t = sprintf('%02d:%02d', $h, $m))
                                                <option value="{{ $t }}">{{ $t }}</option>
                                            @endforeach
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="date-input-container">
                                <div class="input-group">
                                    <i class="bi bi-calendar-minus input-icon"></i>
                                    <input
                                        type="text"
                                        id="departure-date"
                                        name="departure-date"
                                        class="date-picker styled-input"
                                        placeholder="{{ __('messages.reservation_form.departure_date') }}"
                                        required
                                    />
                                </div>
                                <div class="input-group">
                                    <i class="bi bi-alarm input-icon"></i>
                                    <select
                                        id="departure-time"
                                        name="departure-time"
                                        class="time-select styled-input"
                                        required
                                    >
                                        <option value="" disabled selected>{{ __('messages.reservation_form.departure_time') }}</option>
                                        @for ($h = 0; $h < 24; $h++)
                                            @foreach ([0, 30] as $m)
                                                @php($t = sprintf('%02d:%02d', $h, $m))
                                                <option value="{{ $t }}">{{ $t }}</option>
                                            @endforeach
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    <div class="price-section">
                        <div class="price-display">
                            <i class="bi bi-currency-exchange"></i>
                            <h4 id="form-charge">{{ __('messages.reservation_form.price_label') }}</h4>
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    <div class="text-center mt-4">
                        <button type="submit" class="submit-btn">
                            <i class="bi bi-send"></i>
                            {{ __('messages.reservation_form.submit') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</section>
