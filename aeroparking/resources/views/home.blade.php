<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Aero Parking | Najniže cene parkinga na aerodromu Nikola Tesla</title>
    <meta content='Aero Parking je uslužni parking na 2 minuta od aerodroma Nikola Tesla.
Najpovoljnije cene i sezonske akcije do 50%.
Gratis transfer u oba smera.
+381 69 445 4255' name="description">
    <meta content="parking aerodrom nikola tesla" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('img/android-chrome-512x512.png')}}" rel="icon">

    <!-- Google Fonts -->
    <link href="{{asset('google-fonts/google-fonts.css')}}" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('vendor/bootstrap/css/bootstrap.optimized.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/bootstrap-icons/bootstrap-icons.optimized.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/boxicons/css/boxicons.optimized.min.css')}}" rel="stylesheet">
    <!--  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">-->
    <link href="{{asset('vendor/remixicon/remixicon.optimized.min.css')}}" rel="stylesheet">
    <!--  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">-->

    <!-- Deferred css -->
    <link rel="preload" href="{{asset('vendor/glightbox/css/glightbox.min.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{asset('vendor/glightbox/css/glightbox.min.css')}}"></noscript>
    <link rel="preload" href="{{asset('vendor/swiper/swiper-bundle.min.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{asset('vendor/swiper/swiper-bundle.min.css')}}"></noscript>

    <!-- Template Main CSS File -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome-optimized.min.css')}}" rel="stylesheet">

    <!-- Google tag (gtag.js) -->
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-MXC2HV1ZY2');
    </script>
    <script defer src="https://www.googletagmanager.com/gtag/js?id=G-MXC2HV1ZY2"></script>

    <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "ParkingFacility",
          "name": "Aero Parking",
          "description": "Aero Parking je uslužni parking na 2 minuta od aerodroma Nikola Tesla. Najpovoljnije cene i sezonske akcije do 50%. Gratis transfer u oba smera.+381 69 445 4255",
          "url": "http://www.aeroparking.rs",
          "telephone": "+381 69 445 4255",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Put za aerodrom bb",
            "addressLocality": "Beograd",
            "postalCode": "11271",
            "addressCountry": "RS"
          },
          "geo": {
            "@type": "GeoCoordinates",
            "latitude": 44.804032,
            "longitude": 20.300839
          },
          "image": "assets/img/android-chrome-512x512.webp",
          "openingHoursSpecification": [{
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
              "Monday",
              "Tuesday",
              "Wednesday",
              "Thursday",
              "Friday",
              "Saturday",
              "Sunday"
            ],
            "opens": "00:00",
            "closes": "23:59"
          }],
          "sameAs": [
            "https://www.facebook.com/parking.aero",
            "https://www.instagram.com/parking.aero"
          ]
        }

    </script>
</head>

<body>

<!-- ======= Hero Section ======= -->
<section id="pocetna">
    <div class="pocetna-container">
        <h1>AERO PARKING</h1>
        <h2>Parkirajte povoljno i bezbedno, letite bez brige!</h2>

        <div id="reservation-landing">
            <div class="date-inputs">
                <div class="date-input-container">
                    <input id="cta-arrival-date" name="arrival-date" placeholder="Datum od:" onchange="syncInputs(event)">
                </div>
                <div class="separator"></div>
                <div class="date-input-container">
                    <input id="cta-departure-date" name="departure-date" placeholder="Datum do:" onchange="syncInputs(event)">
                </div>

            </div>

            <div id="cta-landing">
                <span>Rezervišite parking mesto</span>
                <span class="divider"></span>
                <span id="cta-charge">Cena: - - -</span>
            </div>
        </div>

    </div>
</section><!-- End Hero -->

<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center ">
    <div id="header-container" class="container-fluid d-flex align-items-center justify-content-lg-between">
        <div class="d-flex align-items-center justify-content-lg-between gap-3">
            <img src="/img/logo-transparent-background-120x120.webp" width="45" height="45" alt="aero parking logo" class="rounded-5">
            <h2 class="logo me-auto me-lg-0">
                <a href="index.html">AERO PARKING</a>
            </h2>
        </div>

        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a class="nav-link scrollto active" href="#pocetna">Početna</a></li>
                <li><a class="nav-link scrollto" href="#pogodnosti">Pogodnosti</a></li>
                <li><a class="nav-link scrollto" href="#cenovnik">Cenovnik</a></li>
                <li><a class="nav-link scrollto" href="#onama">O nama</a></li>
                <li><a class="nav-link scrollto" href="#kontakt">Kontakt</a></li>
            </ul>

            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

        <div class="header-social-links d-none d-lg-flex align-items-center">
            <a href="https://www.facebook.com/parking.aero" class="facebook" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="https://www.instagram.com/parking.aero" class="instagram" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="tel:0694454255" class="phone" aria-label="telephone"><i class="bi bi-telephone"></i></a>

        </div>
    </div>
</header><!-- End Header -->

<main id="main">



    <!-- ======= Services Section ======= -->
    <section id="pogodnosti" class="services">
        <div class="container">

            <div class="section-title">
                <h3>Pogodnosti</h3>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="icon-box" id="credit-card">
                        <div class="icon"><i class="bi bi-credit-card"></i></div>
                        <h4 class="title">Najpovoljniji parking na aerodromu</h4>
                        <p class="description">Cene koje će Vaš novčanik obožavati! Garantovano najpovoljniji parking, kao naš doprinos vašem
                            udobnom putovanju.<br> Proverite detaljnu ponudu klikom na opciju cenovnik ili pozivom na <a href="tel:0694454255"> 069 445 4255</a>.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-briefcase"></i></div>
                        <h4 class="title">Besplatno Vas vozimo!</h4>
                        <p class="description">Besplatan transfer, uz brojne usluge<br>
                            poput pranja vozila, strečovanje kofera i ostalo.<br>
                            Zaboravite na gužve i stresne situacije, <br>mi brinemo o Vama!
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-bar-chart"></i></div>
                        <h4 class="title">Rezervacije</h4>
                        <p class="description">Naš jednostavan sistem rezervacija omogućava Vam da brzo i lako rezervišete parking
                            mesto pre puta.
                            Ne čekajte do poslednjeg trenutka - rezervišite svoje parking mesto sada i uživajte u bezbrižnom
                            putovanju!</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-4">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-alarm"></i></div>
                        <h4 class="title">Radno vreme</h4>
                        <p class="description">
                            Dostupnost - 24/7, 365 dana godišnje - možete računati na nas da osiguramo
                            povoljno i bezbedno mesto za Vaše vozilo.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt-4">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-shield-check"></i></div>
                        <h4 class="title">Čuvamo Vaše vozilo</h4>
                        <p class="description">Vaša sigurnost je naš prioritet, možemo se pohvaliti najsavremenijim 24-časovnim
                            video nadzorom, kompletnom osvetljenošću kao i fizičkim obezbeđenjem.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-4">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-airplane"></i></div>
                        <h4 class="title">Izaberite najbolju opciju!</h4>
                        <p class="description">Aero Parking je tu da vaše putovanje učini još prijatnijim, nudeći najbolji odnos cene i kvaliteta.
                            Obezbedite svoje mesto već danas i prepustite nama brigu o vašem vozilu dok Vi u potpunosti uživate u svojoj putničkoj avanturi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Services Section -->

    <!-- ======= Pricing Section ======= -->
    <section id="cenovnik" class="pricing">
        <div class="container">

            <div class="section-title">
                <h2>Cenovnik</h2>
                <p>Cenovnik se primenjuje prema kalendarskom danu od trenutka kada parkirate vozilo.<br>
                    Ukoliko stignete na parkiralište nakon 22:00h ili završite parkiranje do 02:00,
                    taj dan neće biti uključen u obračun troškova. <br>
                    Prilikom rezervacije biće Vam prosleđene video instrukcije za dolazak do parkinga.<br>
                    <b>Transfer do terminala i nazad je besplatan.</b><br>
                    <b>Za period veći od 40 dana cena iznosi 200rsd dnevno.</b>
                </p>
            </div>
            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="box featured">
                        <h3 class="first-col">Cena za prvih 7 dana</h3>
                        <ul>
                            <li>1 dan/500rsd</li>
                            <li>2 dana/900rsd</li>
                            <li>3 dana/1300rsd</li>
                            <li>4 dana/1700rsd</li>
                            <li>5 dana/2100rsd</li>
                            <li>6 dana/2500rsd</li>
                            <li>7 dana/2900rsd</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-4 mt-md-0">
                    <div class="box featured">
                        <h3 class="second-col">Cena od 8. do 14. dana</h3>
                        <ul>
                            <li>8 dana/3300rsd</li>
                            <li>9 dana/3700rsd</li>
                            <li>10 dana/4100rsd</li>
                            <li>11 dana/4500rsd</li>
                            <li>12 dana/4900rsd</li>
                            <li>13 dana/5100rsd</li>
                            <li>14 dana/5300rsd</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-4 mt-lg-0">
                    <div class="box featured">
                        <h3 class="third-col">Cena od 15. do 21. dana</h3>
                        <ul>
                            <li>15 dana/5500rsd</li>
                            <li>16 dana/5700rsd</li>
                            <li>17 dana/5800rsd</li>
                            <li>18 dana/5900rsd</li>
                            <li>19 dana/6000rsd</li>
                            <li>20 dana/6100rsd</li>
                            <li>21 dana/6200rsd</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-4 mt-lg-0">
                    <div class="box featured">
                        <h3 class="fourth-col">Cena od 22. do 28. dana</h3>
                        <ul>
                            <li>22 dana/6300rsd</li>
                            <li>23 dana/6400rsd</li>
                            <li>24 dana/6500rsd</li>
                            <li>25 dana/6600rsd</li>
                            <li>26 dana/6700rsd</li>
                            <li>27 dana/6800rsd</li>
                            <li>28 dana/6900rsd</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
        <div class="container">
            <div class="row counters">
                <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="2" data-purecounter-duration="1"
                  class="purecounter"></span>
                    <p>minuta do aerodroma</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span class="d-inline-block prefix">od&nbsp;</span> <span data-purecounter-start="0" data-purecounter-end="200" data-purecounter-duration="1"
                                                                              class="purecounter d-inline-block"></span>
                    <p>rsd po danu<sup class="fs-4"><a href="#cenovnik">*</a></sup> </p>
                </div>

                <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="200" data-purecounter-duration="1"
                  class="purecounter d-inline-block"></span><span class="d-inline-block">+</span>
                    <p>parking mesta</p>
                </div>
                <div class="col-lg-3 col-6 text-center">
              <span data-purecounter-start="0" data-purecounter-end="24" data-purecounter-duration="1"
                    class="purecounter"></span>
                    <p>sata video nadzor</p>
                </div>
            </div>
        </div>
    </section><!-- End Counts Section -->
    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
        <div class="container">

            <div class="text-center">
                <h3>Rezervišite Vaše parking mesto</h3>
                <p>
                    Rezervaciju možete izvršiti<br>
                    Pozivom na +381 69 445 4255<br>
                    Putem Viber-a, Whatsapp-a i Instagram-a ili Facebook-a<br>
                    Popunjavanjem kratkog formulara
                </p>
                <a class="cta-btn" id="cta-body">Rezerviši</a>
            </div>
        </div>
    </section><!-- End Cta Section -->

    <!-- ======= About Section ======= -->
    <section id="onama" class="about">
        <div class="container">
            <div class="section-title">
                <h2>O nama</h2>
            </div>
            <div class="row content">
                <div class="col-lg-8">
                    <p>
                        Parking na samo <b>2 minuta</b> udaljenosti od aerodroma Nikola Tesla u Beogradu.<br>
                        Besplatan transfer Vam omogućava da stignete do aerodroma za svega 2 minuta što Vam <br>
                        omogućava praktičnost i uštedu vremena pri putovanju.<br>
                        Zaboravite na gužve i stresne situacije - mi brinemo o Vama.<br>
                        Prilikom rezervacije biće Vam prosleđene video instrukcije za dolazak do Aero parkinga.
                    </p>
                </div>
                <div class="col-lg-4 pt-4 pt-lg-0">
                    <a href="#kontakt" class="btn-learn-more">Lokacija parkinga</a>
                </div>
            </div>
        </div>
    </section><!-- End About Section -->

    <!-- ======= Contact Section ======= -->
    <section id="kontakt" class="contact">
        <div class="container">
            <div class="section-title">
                <h3>Kontakt</h3>
            </div>
            <div class="map-div">
                <iframe style="border:0; width: 100%; height: 470px;" title="google maps"
                        src=https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11323.4418740816!2d20.300839014691345!3d44.804032171070865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a6987e5962bc9%3A0x83125938d680c6f2!2sAerodromski%20parking!5e0!3m2!1ssr!2srs!4v1713703011247!5m2!1ssr!2srs"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Lokacija:</h4>
                            <p>Put za aerodrom bb, Београд 11271</p>
                        </div>

                        <div class="email">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p>rezervacije@aeroparking.rs</p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Telefon:</h4>
                            <p>+381 69 445 4255</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">

    <div class="footer-top">
        <div class="container">
            <div class="row  justify-content-center">
                <div class="col-lg-6">
                    <h3>Aero parking</h3>
                    <p>Vaši utisci su naša najbolja preporuka<br>
                        Zajedno gradimo most ka poverenju koje traje!</p>
                    <img id="footer-logo" src="/img/logo-transparent-180x180.webp" alt="Aero parking logo">
                </div>

            </div>

            <!--        <div class="row footer-newsletter justify-content-center">-->
            <!--          <div class="col-lg-6">-->
            <!--            <form action="" method="post">-->
            <!--              <input type="email" name="email" placeholder="Enter your Email"><input type="submit" value="Subscribe">-->
            <!--            </form>-->
            <!--          </div>-->
            <!--        </div>-->
            <p class="working-hours">Radno vreme 00-24</p>
            <div class="social-links">
                <a href="https://www.facebook.com/parking.aero" class="facebook" aria-label="Facebook"><i class="bx bxl-facebook"></i></a>
                <a href="http://www.instagram.com/parking.aero" class="instagram" aria-label="Instagram"><i class="bx bxl-instagram"></i></a>
                <a href="tel:0694454255" class="phone" aria-label="telephone"><i class="bi bi-telephone"></i></a>
            </div>
        </div>
    </div>

    <div class="container footer-bottom clearfix">
        <div class="copyright">
            Design by: <strong><span>Petar Repac & Zorica Urošević 2024</span></strong>.
        </div>

    </div>
</footer><!-- End Footer -->

<a  id="reserve-btn" class="pulse contact-links-toggle"><i class="bi bi-telephone"></i> KONTAKT</a>

<!-- Contact links -->
<nav id="contact-links"  >
    <i  class="contact-links-close bi bi-x"></i>

    <ul>
        <li id="cta-reserve">
      <span>
      <i class="bi bi-calendar-check"></i>
      Online rezervacija</span>
        </li>

        <li><a href="https://wa.me/+381694454255">
                <i class="bi bi-whatsapp"></i>
                Whatsapp</a>
        </li>
        <li>
            <a  target="_blank" href="viber://chat?number=%2B381694454255">
                <i class="fab fa-viber"></i>
                Viber</a>
        </li>
        <li>
            <a href="mailto:rezervacije@aeroparking.rs">
                <i class="bi bi-envelope" aria-label="Rezervacija"></i>
                Email</a>
        </li>
        <li>
            <a href="tel:0694454255">
                <i class="bi bi-telephone"></i>
                Pozovite nas</a>
        </li>
    </ul>

</nav><!-- .navbar -->



<!-- Contact links -->
<section id="reservation-form"  >
    <i  class="close bi bi-x"></i>
    <section id="contact" class="contact">
        <div class="row mt-2 pb-2">
            <div class="d-flex align-items-center justify-content-lg-center gap-3 p-1 logo">
                <img src="/img/logo-transparent-background-120x120.webp" width="45" height="45" alt="aero parking logo" class="rounded-5">
                <h2 class="me-auto me-lg-0">AERO PARKING REZERVACIJA</h2>
            </div>
            <form id="email-form">
                <div class="form-divider"></div>
                <div class="col-lg-12 mt-5 mt-lg-0">
                    <h4>Lični podaci</h4>

                    <div class="contact-info">
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            id="name"
                            placeholder="Ime i prezime*"
                            required
                        />
                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            id="email"
                            placeholder="Email adresa"
                        />
                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            id="phone"
                            placeholder="Kontakt telefon*"
                            required
                        />
                        <input
                            type="number"
                            class="form-control"
                            name="passengers"
                            id="passengers"
                            placeholder="Broj putnika"
                            min="1"
                        />
                    </div>

                    <div class="form-divider"></div>
                    <h4>Vreme</h4>
                    <div class="date-inputs">
                        <div class="date-input-container">
                            <input type="text" id="arrival-date" name="arrival-date"  class="date-picker" placeholder="Datum od:" required onkeydown="return false;"
                                   style="caret-color: transparent !important;"    />
                            <!--              <input type="date" id="arrival-date" name="arrival-date"  placeholder="Datum od:" onclick="this.showPicker()" oninput="syncInputs(event)" required>-->
                        </div>
                        <div class="date-input-container">
                            <!--              <input type="date" id="departure-date" name="departure-date" placeholder="Datum do:" onclick="this.showPicker()" oninput="syncInputs(event)" required>-->
                            <input type="text" id="departure-date" name="departure-date" class="date-picker" placeholder="Datum do:" required/>

                        </div>

                    </div>
                    <div class="row">
                        <div class="form-divider"></div>
                        <div class="col-md-12 mt-3 mx-auto">
                            <h4 id="form-charge">Cena: ---</h4>
                        </div>
                        <div class="form-divider"></div>


                    </div>
                    <div class="text-center mt-3">
                        <button type="submit">Pošalji rezervaciju</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

</section><!-- .navbar -->


<!-- Vendor JS Files -->
<script src="{{asset('vendor/purecounter/purecounter_vanilla.js')}}"  defer></script>
<!--<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>-->
<script src="{{asset('vendor/glightbox/js/glightbox.min.js')}}"  defer></script>
<script src="{{asset('vendor/isotope-layout/isotope.pkgd.min.js')}}"  async defer></script>
<script src="{{asset('vendor/swiper/swiper-bundle.min.js')}}" defer  ></script>

<!-- Template Main JS File -->
<script src="{{asset('js/main.js')}}" defer></script>

<!-- Sweetalert -->
<script src="{{asset('vendor/sweetalert/js/main.js')}}" async defer></script>

<script src="{{asset('vendor/easepick/js/main.js')}}"></script>

<!-- Template Resevations JS File -->
<script src="{{asset('js/reservation.js')}}" async defer></script>

</body>

</html>
