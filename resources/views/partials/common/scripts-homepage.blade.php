
<!-- Vendor JS Files -->
<script type="module" src="{{asset('vendor/purecounter/purecounter_vanilla.js')}}"  defer></script>
<script type="module" src="{{asset('vendor/glightbox/js/glightbox.min.js')}}"  defer></script>
<script type="module" src="{{asset('vendor/isotope-layout/isotope.pkgd.min.js')}}"  async defer></script>
<script type="module" src="{{asset('vendor/swiper/swiper-bundle.js')}}" defer  ></script>
<script type="module" src="{{asset('vendor/sweetalert/js/main.js')}}" async defer></script>
<script src="{{asset('vendor/flatpickr/js/flatpickr.min.js')}}" defer></script>
@if(app()->getLocale() !== 'en')
<script src="{{asset('vendor/flatpickr/js/l10n/' . app()->getLocale() . '.js')}}" defer></script>
@endif

@include('partials.data.prices')
<script  type="module" src="{{asset('js/reservation.js') . "?" . env('APP_VERSION')}}" defer></script>
<script type="module" src="{{asset('js/main.js') . "?" . env('APP_VERSION')}}" defer></script>
