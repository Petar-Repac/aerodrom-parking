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
                                    required
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
                                    required
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
                                        placeholder="{{ __('messages.reservation_form.arrival') }}"
                                        required
                                        onkeydown="return false;"
                                        style="caret-color: transparent !important;"
                                    />
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
                                        placeholder="{{ __('messages.reservation_form.departure') }}"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    <div class="form-section">
                        <h4><i class="bi bi-chat-left-text"></i> {{ __('messages.reservation_form.additional_info_label') }}</h4>
                        <div class="input-group">
                            <i class="bi bi-pencil input-icon"></i>
                            <textarea
                                name="additional-info"
                                id="additional-info"
                                class="form-control styled-input"
                                rows="3"
                                placeholder="{{ __('messages.reservation_form.additional_info_placeholder') }}"
                            ></textarea>
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

                    <div class="payment-buttons-section">
                        <h4 class="text-center mb-3">
                            <i class="bi bi-credit-card"></i>
                            {{ __('messages.reservation_form.payment_method') }}
                        </h4>
                        <div class="payment-buttons">
                            <button
                                type="submit"
                                class="payment-btn payment-onsite"
                                data-payment-method="payment-onsite"
                            >
                                <i class="bi bi-building"></i>
                                {{ __('messages.reservation_form.pay_onsite') }}
                            </button>

                            <button
                                type="submit"
                                class="payment-btn payment-online"
                                data-payment-method="payment-online"
                            >
                                <i class="bi bi-credit-card-2-front"></i>
                                {{ __('messages.reservation_form.pay_online') }}
                            </button>
                        </div>
                        <p class="payment-info text-center mt-2">
                            <small>{{ __('messages.reservation_form.payment_info') }}</small>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </section>
</section>

<style>
    .payment-buttons-section {
        margin-top: 1rem;
    }

    .payment-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .payment-btn {
        flex: 1;
        min-width: 200px;
        padding: 1rem 1.5rem;
        border: 2px solid transparent;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .payment-btn i {
        font-size: 1.2rem;
    }

    .payment-onsite {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }

    .payment-onsite:hover:not(:disabled) {
        background-color: #218838;
        border-color: #1e7e34;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }

    .payment-online {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .payment-online:hover:not(:disabled) {
        background-color: #0056b3;
        border-color: #004085;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }

    .payment-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .payment-info {
        color: #6c757d;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .payment-buttons {
            flex-direction: column;
        }

        .payment-btn {
            width: 100%;
            min-width: unset;
        }
    }
</style>
