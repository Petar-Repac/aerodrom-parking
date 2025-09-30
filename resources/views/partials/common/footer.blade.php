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
                    </p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/parking.aero" class="facebook" aria-label="Facebook"><i class="bx bxl-facebook"></i></a>
                        <a href="http://www.instagram.com/parking.aero" class="instagram" aria-label="Instagram"><i class="bx bxl-instagram"></i></a>
                        <a href="tel:0694454255" class="phone" aria-label="telephone"><i class="bi bi-telephone"></i></a>
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
</footer><!-- End Footer -->
