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
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ App\Helpers\RouteHelper::localizedRoute('terms') }}">{{ __('messages.nav.terms') }}</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="{{ App\Helpers\RouteHelper::localizedRoute('privacy') }}">{{ __('messages.nav.privacy') }}</a></li>
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
                        <div class="payment-logos-list">
                            <a href="https://www.visa.com" target="_blank" rel="noopener"><img src="/img/payment/Visa50.gif" alt="Visa" class="footer-card-logo"></a>
                            <a href="https://www.mastercard.com" target="_blank" rel="noopener"><img src="/img/payment/MasterCard50.gif" alt="Mastercard" class="footer-card-logo"></a>
                            <img src="/img/payment/maestro50.gif" alt="Maestro" class="footer-card-logo">
                            <img src="/img/payment/dinacard50.png" alt="DinaCard" class="footer-card-logo">
                            <a href="http://www.wspay.rs" title="Monri WSpay - Web Secure Payment Gateway" target="_blank"><img alt="Monri WSpay - Web Secure Payment Gateway" src="https://www.wspay.info/payment-info/wsPayWebSecureLogo-118x50-transparent.png" border="0"></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Protocol & Business Bank Logos Row -->
            <div class="row">
                <div class="col-12">
                    <div class="footer-payment-logos">
                        <div class="payment-logos-list">
                            <a href="https://rs.visa.com/pay-with-visa/security-and-assistance/security.html" title="Bezbednost | Visa" target="_blank" rel="noopener"><img src="/img/payment/visa-secure.png" alt="Visa Secure" class="footer-card-logo"></a>
                            <a href="https://www.mastercard.com/rs/sr/personalizovano/prona%C4%91i-karticu.html" title="Pronađite odgovarajuću vrstu Mastercard platne kartice za sebe" target="_blank" rel="noopener"><img src="/img/payment/mastercard-identity-check.png" alt="Mastercard ID Check" class="footer-card-logo"></a>
                            <a href="https://www.raiffeisenbank.rs/" title="Raiffeisen banka a.d. Beograd" target="_blank" rel="noopener"><img src="/img/payment/raiffeisen.png" alt="Raiffeisen banka" class="footer-card-logo"></a>
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
            padding: 0.75rem 0;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .payment-logos-list {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.75rem;
        }
        .footer-card-logo {
            height: 50px;
            width: auto;
        }
        #footer .footer-bottom .copyright a[href*="webwisteria"] {
            color: rgba(255,255,255,0.45);
            font-weight: 400;
            font-size: 0.8rem;
            letter-spacing: 0.03em;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        #footer .footer-bottom .copyright a[href*="webwisteria"]:hover {
            color: rgba(255,255,255,0.75);
        }
        #footer .footer-bottom .copyright strong {
            font-weight: 400;
        }
    </style>
</footer><!-- End Footer -->
