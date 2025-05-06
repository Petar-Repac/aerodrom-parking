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
                            <input type="text" id="arrival-date" name="arrival-date"  class="date-picker" placeholder="Datum dolaska:" required onkeydown="return false;"
                                   style="caret-color: transparent !important;"    />
                            <!--              <input type="date" id="arrival-date" name="arrival-date"  placeholder="Datum dolaska:" onclick="this.showPicker()" oninput="syncInputs(event)" required>-->
                        </div>
                        <div class="date-input-container">
                            <!--              <input type="date" id="departure-date" name="departure-date" placeholder="Datum povratka:" onclick="this.showPicker()" oninput="syncInputs(event)" required>-->
                            <input type="text" id="departure-date" name="departure-date" class="date-picker" placeholder="Datum povratka:" required/>

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
