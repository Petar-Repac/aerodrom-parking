<?php

return [
    // Navigation
    'nav' => [
        'home' => 'Početna',
        'pricing' => 'Cenovnik',
        'about' => 'O nama',
        'contact' => 'Kontakt',
        'terms' => 'Uslovi korišćenja',
    ],

    // Hero Section
    'hero' => [
        'title' => 'AERO PARKING',
        'subtitle' => 'Parkirajte povoljno i bezbedno, letite bez brige!',
        'arrival_date' => 'Datum dolaska:',
        'departure_date' => 'Datum povratka:',
        'reserve_button' => 'Rezervišite parking mesto',
        'price' => 'Cena: - - -',
    ],

    // Contact Button
    'contact_btn' => 'KONTAKT',

    // Contact Links
    'contact_links' => [
        'online_reservation' => 'Online rezervacija',
        'whatsapp' => 'Whatsapp',
        'viber' => 'Viber',
        'email' => 'Email',
        'call_us' => 'Pozovite nas',
    ],

    // Reservation Form
    'reservation_form' => [
        'title' => 'PARKING REZERVACIJA',
        'personal_data' => 'Lični podaci',
        'name' => 'Ime i prezime*',
        'email' => 'Email adresa',
        'phone' => 'Kontakt telefon*',
        'passengers' => 'Broj putnika',
        'time' => 'Vreme',
        'arrival' => 'Datum dolaska*',
        'departure' => 'Datum povratka*',
        'price_label' => 'Cena: ---',
        'submit' => 'Pošalji rezervaciju',

        // NEW KEYS for payment integration
        'additional_info_label' => 'Dodatne informacije',
        'additional_info_placeholder' => 'Unesite dodatne informacije ili posebne zahteve...',
        'payment_method' => 'Izaberite način plaćanja',
        'pay_onsite' => 'Plaćanje na licu mesta',
        'pay_online' => 'Plaćanje karticom',
        'payment_info' => 'Možete platiti odmah karticom ili kasnije na licu mesta',
        'terms_agree' => 'Pročitao/la sam i prihvatam <a href=":url" target="_blank">Uslove korišćenja</a> *',
    ],

    'payment' => [
        // Success page
        'success_title' => 'Plaćanje uspešno!',
        'success_message' => 'Vaše plaćanje je uspešno izvršeno. Hvala što ste izabrali Aeroparking!',

        // Error page
        'error_title' => 'Plaćanje nije uspelo',
        'error_message' => 'Došlo je do greške prilikom obrade Vašeg plaćanja.',

        // Cancel page
        'cancel_title' => 'Plaćanje otkazano',
        'cancel_message' => 'Odustali ste od plaćanja. Vaša rezervacija nije naplaćena.',

        // Common fields
        'reservation_details' => 'Detalji rezervacije',
        'reservation_number' => 'Broj rezervacije',
        'name' => 'Ime i prezime',
        'email' => 'Email',
        'phone' => 'Telefon',
        'arrival' => 'Dolazak',
        'departure' => 'Odlazak',
        'duration' => 'Trajanje',
        'days' => 'dana',
        'total_amount' => 'Ukupan iznos',

        // Payment information
        'payment_information' => 'Informacije o plaćanju',
        'transaction_id' => 'ID transakcije',
        'approval_code' => 'Kod odobrenja',
        'payment_date' => 'Datum plaćanja',
        'card_number' => 'Broj kartice',

        // Messages
        'confirmation_email_sent' => 'Email sa potvrdom je poslat na Vašu adresu. Neko iz našeg tima će Vas uskoro kontaktirati.',
        'back_to_home' => 'Nazad na početnu',
        'transaction_failed_notice' => 'Transakcija je neuspešna, račun platne kartice nije zadužen.',
        'total_amount_with_vat' => 'Ukupno sa PDV-om',

        // Error page specific
        'error_details' => 'Detalji greške',
        'your_reservation' => 'Vaša rezervacija',
        'error_help' => 'Šta možete da uradite:',
        'try_again_later' => 'Pokušajte ponovo za nekoliko minuta',
        'check_card_details' => 'Proverite da li su podaci o kartici tačni',
        'contact_bank' => 'Kontaktirajte svoju banku',
        'choose_onsite_payment' => 'Izaberite plaćanje na licu mesta',
        'try_again' => 'Pokušaj ponovo',
        'need_help' => 'Potrebna Vam je pomoć?',

        // Cancel page specific
        'cancelled_reservation' => 'Otkazana rezervacija',
        'what_happens_now' => 'Šta se dešava sada?',
        'no_charge_made' => 'Vaša kartica nije naplaćena',
        'can_try_again' => 'Možete ponovo pokušati sa plaćanjem',
        'or_choose_onsite' => 'Ili izaberite plaćanje na licu mesta',
        'complete_reservation' => 'Završite rezervaciju',
        'questions' => 'Imate pitanja?',

        // Customer emails
        'subject_confirmation' => 'Potvrda rezervacije :id — Aeroparking',
        'subject_failed' => 'Neuspešno plaćanje - Aeroparking',
        'greeting' => 'Poštovani/a :name,',
        'thank_you_title' => 'Hvala što ste rezervisali sa nama!',
        'thank_you_message' => 'Vaša rezervacija je uspešno primljena i obrađena. Uskoro ćemo Vas kontaktirati da potvrdimo sve detalje.',
        'thank_you_message_paid' => 'Vaša rezervacija je potvrđena i plaćanje je uspešno izvršeno.',
        'at' => 'u',
        'around' => 'oko',
        'duration_note' => '(obračun po započetom danu)',
        'transfer_heading' => 'Besplatan transfer',
        'transfer_text' => 'U cenu je uključen besplatan transfer do aerodroma i nazad za :passengers putnika. Naš vozač Vas vozi do terminala odmah po predaji vozila, a po povratku Vas čekamo.',
        'transfer_recommendation' => 'Preporučujemo da na parking stignete najkasnije 2 sata i 30 minuta pre poletanja.',
        'directions_heading' => 'Kako do nas',
        'address_label' => 'Adresa',
        'address_value' => 'Sremskih Partizana 133, Surčin',
        'maps_link_text' => 'Pogledajte na Google mapi',
        'status_label' => 'Status',
        'payment_method_label' => 'Način plaćanja',
        'pay_onsite_value' => 'na licu mesta, prilikom dolaska',
        'amount_paid_label' => 'Iznos (sa PDV-om)',
        'amount_due_label' => 'Iznos za uplatu (sa PDV-om)',
        'accepted_payment_methods' => 'Prihvatamo: Gotovina / platne kartice',
        'cancellation_heading' => 'Otkazivanje rezervacije',
        'free_cancellation_label' => 'Besplatno otkazivanje',
        'free_cancellation_text' => 'do 24 sata nakon izvršene rezervacije — povraćaj punog iznosa u roku od 7 dana.',
        'no_show_label' => 'Nedolazak (no-show)',
        'no_show_text' => 'zadržava se pun iznos rezervacije.',
        'passengers' => 'Broj putnika',
        'notes_title' => 'Vaše napomene',
        'next_steps_title' => 'Šta je sledeće?',
        'next_step_contact' => 'Naš tim će Vas kontaktirati u najkraćem roku na navedeni broj telefona',
        'next_step_confirm' => 'Potvrdićemo sve detalje Vaše rezervacije',
        'next_step_instructions' => 'Dobićete dodatne instrukcije o dolasku na parking',
        'next_step_prepare' => 'Priprema Vašeg parking mesta biće završena do datuma dolaska',
        'contact_info_title' => 'Kontakt Informacije',
        'contact_intro' => 'Ukoliko imate bilo kakvih pitanja, slobodno nas kontaktirajte:',
        'working_hours_label' => 'Radno vreme:',
        'available_247' => 'Dostupni smo 24/7 za sve Vaše potrebe',
        'safe_parking_message' => 'Bezbedno i sigurno parkiranje uz najbolju uslugu!',
        'footer_tagline' => 'Profesionalni parking servis u blizini aerodroma',
        'footer_auto_notice' => 'Ovo je automatska poruka. Molimo Vas da ne odgovarate direktno na ovaj email. Za sva pitanja, koristite kontakt informacije navedene iznad.',
        'footer_rights' => 'Sva prava zadržana.',
        'payment_completed_status' => 'Plaćanje uspešno izvršeno',
        'failed_transaction_title' => 'Transakcija je neuspešna',
        'card_not_charged' => 'Račun platne kartice nije zadužen.',
        'failed_intro_message' => 'Nažalost, Vaše plaćanje nije moglo biti obrađeno. Molimo pokušajte ponovo ili nas kontaktirajte.',
    ],

    // Pricing Section
    'pricing' => [
        'title' => 'Cenovnik',
        'description' => 'Cenovnik se primenjuje prema kalendarskom danu od trenutka kada parkirate vozilo.<br>Ukoliko stignete na parkiralište nakon 22:00h ili završite parkiranje do 02:00, taj dan neće biti uključen u obračun troškova.<br>Prilikom rezervacije biće Vam prosleđene video instrukcije za dolazak do parkinga.<br><b>Transfer do terminala i nazad je besplatan.</b><br><b>Za period veći od 40 dana cena iznosi 200rsd dnevno.</b>',
        'days' => 'dana',
        'day' => 'dan',
        'long_term' => '40+ dana',
        'per_day' => '200 rsd/dan',
        'click_price' => 'Kliknite na bilo koju cenu za rezervaciju',
        'rsd' => 'rsd',
    ],

    // About Section
    'about' => [
        'title' => 'O nama',
        'description' => 'Aero Parking se nalazi na samo <b>2 minuta</b> udaljenosti od aerodroma Nikola Tesla u Beogradu, kapaciteta od <b>preko 500</b> parking mesta za naše klijente.<br>Usluga je osmišljena tako da omogućava uštedu vremena i novca, koji su najvažniji faktori pri planiranju putovanja.<br>Naš parking je u potpunosti ogradjen, osvetljen, pokriven 24 časovnim video nadzorom uz prisustvo fizičkog obezbedjenja.<br>Radno vreme je 24 časa dnevno, 7 nedeljno, 365 dana u godini.',
        'location_button' => 'Lokacija parkinga',
    ],

    // Counts Section
    'counts' => [
        'minutes_to_airport' => 'minuta do aerodroma',
        'from' => 'od',
        'per_day' => 'rsd po danu',
        'parking_spots' => 'parking mesta',
        'video_surveillance' => 'sata video nadzor',
    ],

    // CTA Section
    'cta' => [
        'title' => 'Rezervišite Vaše parking mesto',
        'description' => 'Rezervaciju možete izvršiti<br>Pozivom na +381 69 445 4255<br>Putem Viber-a, Whatsapp-a i Instagram-a ili Facebook-a<br>Popunjavanjem kratkog formulara',
        'button' => 'Rezerviši',
    ],

    // Procedure Section
    'procedure' => [
        'title' => 'Kako koristiti našu uslugu',
        'description' => 'Pratite ove jednostavne korake da biste rezervisali i koristili usluge našeg aerodromskog parkinga.',
        'step_01' => [
            'title' => 'Rezervišite parking',
            'description' => 'Prvi korak je <a href="#">rezervacija parking mesta</a>.<br>Parking na aerodromu možete rezervisati na našem veb sajtu odabirom datuma na vrhu stranice, putem WhatsApp i Viber aplikacija,<br> kao i putem e-mail adrese <a href="mailto:rezervacije@aeroparking.rs"> rezervacije@aeroparking.rs</a>',
        ],
        'step_02' => [
            'title' => 'Potvrda rezervacije',
            'description' => 'Drugi korak je potvrda nakon obavljene rezervacije, kontaktiraćemo Vas sa potvrdom u kojoj<br> će se nalaziti smernice do parkinga koji je udaljen na samo 2 minuta od aerodroma Nikola Tesla.',
        ],
        'step_03' => [
            'title' => 'Parkiranje i transfer',
            'description' => 'Treći korak je dolazak na parking nakon čega vas naši zaposleni službenim vozilima voze do terminala za odlazne letove na aerodromu Nikola Tesla.',
        ],
        'step_04' => [
            'title' => 'Dolazak i preuzimanje vozila',
            'description' => 'Po povratku sa putovanja dočekaćemo vas kod terminala i vratiti do vašeg vozila.',
        ],
    ],

    // Services Section
    'services' => [
        'title' => 'Pogodnosti',
        'affordable' => [
            'title' => 'Najpovoljniji parking na aerodromu',
            'description' => 'Nudimo garantovano najpovoljnije cene parkiranja na aerodromu. Proverite detaljnu ponudu klikom na opciju cenovnik u meniju ili putem kontakt centra <a href="tel:381694454255"> +381 69 445 4255 </a> udobnom putovanju.<br> Proverite detaljnu ponudu klikom na opciju cenovnik ili pozivom na 069 445 4255.',
        ],
        'free_transfer' => [
            'title' => 'Besplatno Vas vozimo!',
            'description' => 'Transfer do i sa terminala je uz korišćenje usluga parkinga besplatan!',
        ],
        'reservations' => [
            'title' => 'Rezervacije',
            'description' => 'Laka i brza rezervacija osigurava parking mesto na aerodromu pre puta.<br> Ne čekajte do poslednjeg trenutka, rezervišite svoje mesto unapred.',
        ],
        'working_hours' => [
            'title' => 'Radno vreme',
            'description' => 'Radno vreme parkinga je 24 časa dnevno, 365 dana u godini.',
        ],
        'security' => [
            'title' => 'Čuvamo Vaše vozilo',
            'description' => 'Sigurnost vozila naših klijenata je najveći prioritet, <br> Aero Parking je u potpunosti ogradjen, osvetljen, pokriven 24 časovnim savremenim video nadzorom,<br> uz to imamo i prisustvo fizičkog obezbedjenja.',
        ],
        'best_option' => [
            'title' => 'Izaberite najbolju opciju!',
            'description' => 'Trudimo se da vaše putovanje učinimo što prjatnijim, uz profesionalnu uslugu, brz i besplatan transfer u oba smera,<br> niz pratećih usluga povoljnijih nego na samom aerodromu poput zaštite kofera, ponude hladnih i toplih napitaka.',
        ],
    ],

    // Footer
    'footer' => [
        'tagline' => 'Vaši utisci su naša najbolja preporuka<br>Zajedno gradimo most ka poverenju koje traje!',
        'working_hours' => 'Radno vreme 00-24',
        'useful_links' => 'Korisni linkovi',
        'contact_info' => 'Kontakt informacije',
        'phone' => 'Telefon',
        'location' => 'Lokacija',
        'location_value' => 'Aerodrom Nikola Tesla',
        'working_hours_label' => 'Radno vreme',
        'working_hours_value' => '24/7',
        'design_by' => 'Design by: <strong><span><a href="https://webwisteria.com" target="_blank">WebWisteria</a></span></strong>',
        'benefits' => 'Pogodnosti',
        'accepted_payments' => 'Prihvaćene kartice',
    ],

    // Meta
    'meta' => [
        'title' => 'Aero Parking | Najpovoljniji parking na aerodromu Nikola Tesla',
        'description' => 'Aero Parking – Siguran i povoljan parking nadomak Aerodroma Beograd. Najpovoljniji parking, 24/7 nadzor i besplatan transfer do terminala. Rezervišite online!',
        'keywords' => 'parking aerodrom, Nikola Tesla aerodrom, parking Beograd, transfer aerodrom, jeftin parking, rezervacija parking',
    ],
    // Contact Section
    'contact' => [
        'title' => 'Kontakt',
        'send_message' => 'Pošaljite nam poruku',
        'loading' => 'Šalje se...',
        'error_message' => 'Došlo je do greške. Molimo pokušajte ponovo.',
        'success_message' => 'Vaša poruka je poslata. Hvala vam!',
        'name' => 'Ime i prezime *',
        'name_placeholder' => 'Vaše ime i prezime',
        'email' => 'Email adresa *',
        'email_placeholder' => 'vaš@email.com',
        'phone' => 'Telefon',
        'phone_placeholder' => '+381 69 445 4255',
        'subject' => 'Naslov poruke *',
        'subject_placeholder' => 'Ukratko opišite razlog kontakta',
        'message' => 'Poruka *',
        'message_placeholder' => 'Detaljno opišite vaš upit ili potrebu...',
        'submit' => 'Pošaljite poruku',
    ],
    // 404 Page
    'page_not_found' => [
        'title' => 'Stranica nije pronađena!',
        'description' => 'Sadržaj koji tražite je možda uklonjen, ili se ne nalazi na ovoj lokaciji.',
        'back_home' => 'Povratak na početnu',
    ],
    // Opšti uslovi korišćenja i prodaje
    'terms' => [
        'title' => 'Opšti uslovi korišćenja i prodaje',
        'intro' => 'Ovi Opšti uslovi korišćenja i prodaje (u daljem tekstu: „Uslovi") regulišu odnose između Nexus Temporis Corporation d.o.o. (u daljem tekstu: „Mi", „Nas" ili „Prodavac"), sa sedištem u Beogradu, i korisnika usluga (u daljem tekstu: „Vi" ili „Korisnik") na veb-sajtu za rezervaciju aerodromskog parkinga (u daljem tekstu: „Sajt"). Ovi Uslovi predstavljaju obavezujući ugovor između strana. Korišćenjem Sajta ili rezervacijom usluge, Korisnik potvrđuje da je pročitao, razumeo i prihvatio ove Uslove u celini.<br><br>Ovi Uslovi važe za ogranak firme Nexus Temporis Corporation d.o.o. koji se bavi uslugama aerodromskog parkinga sa transferom (u daljem tekstu: „Aero Parking ogranak"). Ako imate pitanja, kontaktirajte nas na dole navedene podatke.',

        'section_1' => [
            'title' => '1. Podaci o prodajnom mestu',
            'content' => '<strong>Pun naziv kompanije:</strong> Nexus Temporis Corporation d.o.o. (Aero Parking ogranak)<br><strong>Adresa sedišta:</strong> Trg Nikole Pašića 7, 11158, Beograd (Stari Grad), Republika Srbija<br><strong>PIB:</strong> 113083367<br><strong>Matični broj:</strong> 21798487<br><br><strong>Kontakt:</strong><br>Telefon: 069/445-4255<br>Email: rezervacije@aeroparking.rs<br>Veb-sajt: aeroparking.rs<br><br>Sve usluge se pružaju u skladu sa Zakonom o zaštiti potrošača Republike Srbije i drugim relevantnim propisima.',
        ],

        'section_2' => [
            'title' => '2. Informacije o proizvodima i/ili uslugama',
            'content' => 'Mi pružamo uslugu aerodromskog parkinga na Aerodromu Nikola Tesla Beograd (BEG), sa besplatnim transferom u oba smera do i sa terminala (shuttle usluga). Usluga uključuje:<br><br>— Sigurno parkiranje vozila na ograđenom, osvetljenom i video-nadziranom prostoru (24/7 nadzor).<br>— Besplatan transfer do i sa terminala (oko 2–5 minuta vožnje).<br><br><strong>Ograničenja:</strong> Usluga je namenjena ličnim vozilima (automobili, SUV-i); nema podrške za kamione ili vozila veća od 5m dužine. Parking nije odgovoran za lične stvari ostavljene u vozilu.<br><br><strong>Lokacija parkinga:</strong> Sremskih Partizana 133, Surčin<br><br>Usluga je dostupna 24/7, uključujući vikende i praznike. Rezervacija se vrši unapred preko Sajta, ali je moguće plaćanje i na licu mesta (uživo).',
        ],

        'section_3' => [
            'title' => '3. Uslovi prodaje (uključujući plaćanje, dostavu, reklamacije)',
            'content' => '<strong>Plaćanje:</strong><br>Podržane metode: Online plaćanje karticama (Visa, Mastercard, DinaCard, American Express) unapred preko Sajta.<br>Valuta: RSD (srpski dinari).<br>Plaćanje uživo: Moguće na licu mesta kešom ili karticom (iste vrste kartica).<br>Nema skrivenih troškova; transfer je besplatan.<br><br><strong>Dostava usluge:</strong><br>Nakon uspešne rezervacije i plaćanja, Korisnik dobija potvrdu na email za pristup parkingu.<br>Dostava: Usluga se pruža na teritoriji Republike Srbije (Surčin).<br>Rok: Odmah po dolasku na parking, sa transferom u roku od 5–10 minuta.<br><br><strong>Reklamacije i otkazivanje:</strong><br>Rok za otkaz prilikom online plaćanja: Besplatan otkaz do 24 sata nakon izvršene rezervacije (povraćaj punog iznosa u roku od 7 dana). No-show (nedolazak): pun iznos se zadržava.<br>Reklamacije: Korisnik može podneti reklamaciju u roku od 7 dana od završetka usluge (npr. oštećenje vozila). Kontaktirajte nas email-om ili telefonom; odgovor u roku od 48 sati.<br>Povraćaj novca: Preko iste metode plaćanja, u skladu sa Zakonom o zaštiti potrošača.',
        ],

        'section_4' => [
            'title' => '4. Način zaštite poverljivih podataka',
            'content' => 'Štitimo poverljive podatke Korisnika u skladu sa Zakonom o zaštiti podataka o ličnosti Republike Srbije i GDPR standardima (gde primenljivo). Merenja zaštite uključuju:<br><br>— Upotrebu SSL/TLS enkripcije za sve transakcije na Sajtu (HTTPS protokol).<br>— Podaci o plaćanju (brojevi kartica) se ne čuvaju na našim serverima; oni se obrađuju direktno preko sigurnog payment gateway-a (tokenizacija).<br>— Fizička i digitalna zaštita: Serveri su hostovani u sigurnim data centrima sa firewall-ovima, antivirusima i redovnim bezbednosnim auditima.',
        ],

        'section_5' => [
            'title' => '5. Izjava o prikupljanju i korišćenju ličnih podataka',
            'content' => 'Prikupljamo sledeće lične podatke prilikom rezervacije: ime i prezime, email adresa, broj telefona, registarska oznaka vozila, datumi i vreme dolaska/odlaska, broj leta (opciono).<br><br><strong>Svrha prikupljanja:</strong> Obrada rezervacije, slanje potvrde, kontakt u slučaju izmena (npr. kašnjenje leta), unapređenje usluga. Ne koristimo za marketing bez izričite saglasnosti.<br><br><strong>Osnov za obradu:</strong> Ugovorna obaveza (čl. 12 Zakona o zaštiti podataka o ličnosti). Saglasnost se dobija prilikom rezervacije (checkbox).<br><br><strong>Deljenje podataka:</strong> Samo sa neophodnim partnerima (npr. payment provajder, kurir za transfer). Ne prodajemo podatke trećim licima.<br><br><strong>Prava Korisnika:</strong> Možete zatražiti pristup, ispravku, brisanje ili ograničenje obrade podataka slanjem zahteva na rezervacije@aeroparking.rs. Rok za odgovor: 30 dana. Podaci se čuvaju 2 godine posle usluge (zbog poreskih obaveza), zatim se brišu.<br><br>Detaljna Politika privatnosti dostupna na Sajtu.',
        ],

        'section_6' => [
            'title' => '6. Izjava o konverziji (za stranice sa inostranim karticama)',
            'content' => 'Kod plaćanja inostranim karticama (npr. iz EU ili SAD), iznos se obračunava u dinarskoj protivvrednosti po srednjem kursu Narodne banke Srbije (NBS) na dan transakcije, ili po kursu banke koja vrši autorizaciju. Mogući su dodatni troškovi konverzije od strane izdavaoca kartice (npr. 1–3% fee), za koje Mi nismo odgovorni. Preporučujemo proveru sa vašom bankom pre plaćanja. Sva plaćanja su u RSD; nema podrške za druge valute direktno.',
        ],

        'section_7' => [
            'title' => '7. Izjave o plaćanju i bezbednosti (WSpay/Monri)',
            'content' => '<strong>Autorizacija plaćanja:</strong><br>Plaćanje se vrši putem WSpay sistema za naplatu, ovlašćenog od strane Monri Payments. Plaćanje karticom je u potpunosti bezbedno: podaci o kartici se unose direktno na stranici banke/procesora i nijednog trenutka nisu dostupni prodavcu. Prodavac ne čuva podatke o kartici kupca.<br><br><strong>Zaštita podataka o kartici:</strong><br>Za realizaciju plaćanja koristi se WSpay sistem koji primenjuje PCI DSS standard za zaštitu podataka o platnim karticama. Svi podaci o kartici prenose se SSL enkripcijom (256-bit). Prodavac ne dolazi u posed podataka o kartici niti ih čuva.<br><br><strong>Reklamacije za naplatu:</strong><br>Ukoliko smatrate da je Vaša kartica pogrešno naplaćena, molimo Vas da nas kontaktirate na rezervacije@aeroparking.rs ili +381 69 445 4255. Sve reklamacije rešavamo u roku od 24 sata. Ako se radi o neautorizovanoj transakciji, molimo Vas da kontaktirate banku koja je izdala Vašu karticu.<br><br><strong>Prihvaćene kartice:</strong> Visa, Mastercard, Maestro, DinaCard, American Express.<br><br><strong>Valuta:</strong> Sve transakcije su u RSD (srpski dinari). Nema skrivenih troškova.<br><br><strong>PDV izjava:</strong><br>Nexus Temporis Corporation d.o.o. nije u sistemu PDV-a. Iskazane cene su konačne i ne podležu dodatnom obračunu PDV-a.<br><br>{{-- TODO: Ako je kompanija u sistemu PDV-a, zameniti gornju rečenicu sa: "PDV je uračunat u iskazane cene. Na svakom koraku kupovine, ukupna (total) cena proizvoda/usluge prikazana je sa PDV-om (ukupno sa PDV-om)." --}}',
        ],

        'closing' => 'Ovi Uslovi mogu se menjati; obaveštavamo Korisnike email-om ili na Sajtu.',
    ],
];
