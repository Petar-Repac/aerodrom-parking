<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <!-- Company Info Section -->
                <div class="col-lg-4 col-md-6 footer-info">
                    <h3>Aero parking</h3>
                    <p>{!! __('messages.footer.tagline') !!}</p>
                    <img id="footer-logo" src="/img/logo-transparent-180x180.webp" alt="Aero parking logo">
                    <p class="working-hours">{{ __('messages.footer.working_hours') }}</p>
                </div>

                <!-- Useful Links Section -->
                <div class="col-lg-4 col-md-6 footer-links">
                    <h4>{{ __('messages.footer.useful_links') }}</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{route('home')}}">{{ __('messages.nav.home') }}</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{route('about')}}">{{ __('messages.nav.about') }}</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#pogodnosti">{{ __('messages.footer.benefits') }}</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{route('pricing')}}">{{ __('messages.nav.pricing') }}</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{route('contact')}}">{{ __('messages.nav.contact') }}</a></li>
                    </ul>
                </div>

                <!-- Contact Info Section -->
                <div class="col-lg-4 col-md-12 footer-contact">
                    <h4>{{ __('messages.footer.contact_info') }}</h4>
                    <p>
                        <strong>{{ __('messages.footer.phone') }}:</strong> +381 69 445 4255<br>
                        <strong>{{ __('messages.footer.location') }}:</strong> {{ __('messages.footer.location_value') }}<br>
                        <strong>{{ __('messages.footer.working_hours_label') }}:</strong> {{ __('messages.footer.working_hours_value') }}<br>
                        <strong>PIB:</strong> 113083367<br>
                        <strong>MB:</strong> 21798487<br>
                    </p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/parking.aero" class="facebook" aria-label="Facebook"><i class="bx bxl-facebook"></i></a>
                        <a href="http://www.instagram.com/parking.aero" class="instagram" aria-label="Instagram"><i class="bx bxl-instagram"></i></a>
                        <a href="tel:0694454255" class="phone" aria-label="telephone"><i class="bi bi-telephone"></i></a>
                    </div>
                </div>
            </div>

            <!-- Payment Logos Row -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="footer-payment-logos">
                        <span class="payment-logos-label">{{ __('messages.footer.accepted_payments') }}:</span>
                        <div class="payment-logos-list">
                            {{-- TODO: Replace these badge placeholders with official card/WsPay logo images
                                 Suggested: /img/visa.svg, /img/mastercard.svg, /img/dinacard.svg, /img/maestro.svg, /img/wspay.png --}}
                            <span class="payment-logo-badge">VISA</span>
                            <span class="payment-logo-badge">Mastercard</span>
                            <span class="payment-logo-badge">Maestro</span>
                            <span class="payment-logo-badge">DinaCard</span>
                            <span class="payment-logo-badge">American Express</span>
                            <span class="payment-logo-badge wspay-badge">WSpay</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container footer-bottom clearfix">
        <div class="copyright">
            {!! __('messages.footer.design_by') !!}
        </div>
    </div>

    <style>
        .footer-payment-logos {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0.75rem 0;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .payment-logos-label {
            font-size: 0.85rem;
            color: #ccc;
            white-space: nowrap;
        }
        .payment-logos-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
        }
        .payment-logo-badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #fff;
            background: rgba(255,255,255,0.08);
            letter-spacing: 0.02em;
        }
        .wspay-badge {
            background: rgba(0, 90, 170, 0.4);
            border-color: rgba(0, 90, 170, 0.6);
        }
    </style>
</footer><!-- End Footer -->
