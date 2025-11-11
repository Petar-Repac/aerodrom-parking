<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potvrda Rezervacije - Aeroparking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .success-message {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .reservation-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #666;
        }
        .detail-value {
            color: #333;
            text-align: right;
        }
        .total-price {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        .payment-info {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .info-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .contact-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .contact-info a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            color: #666;
            font-size: 14px;
        }
        .icon {
            font-size: 24px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>✅ Potvrda Rezervacije</h1>
    <p style="margin: 5px 0 0 0; font-size: 16px;">Aeroparking - Parking servis</p>
</div>

<div class="content">
    <div class="success-message">
        <h2 style="margin: 0 0 10px 0; color: #155724;">Hvala što ste rezervisali sa nama!</h2>
        <p style="margin: 0;">Vaša rezervacija je uspešno primljena i obrađena. Uskoro ćemo Vas kontaktirati da potvrdimo sve detalje.</p>
    </div>

    <div class="reservation-details">
        <h3 style="margin-top: 0; color: #667eea;">📋 Vaši Podaci o Rezervaciji</h3>

        <div class="detail-row">
            <span class="detail-label">Broj rezervacije:</span>
            <span class="detail-value">{{ $reservation['reservation_id'] }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Ime i prezime:</span>
            <span class="detail-value">{{ $reservation['name'] }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Email:</span>
            <span class="detail-value">{{ $reservation['email'] }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Telefon:</span>
            <span class="detail-value">{{ $reservation['phone'] }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Broj putnika:</span>
            <span class="detail-value">{{ $reservation['passengers'] }}</span>
        </div>
    </div>

    <div class="reservation-details">
        <h3 style="margin-top: 0; color: #667eea;">📅 Detalji Parkinga</h3>

        <div class="detail-row">
            <span class="detail-label">Datum dolaska:</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($reservation['arrival_date'])->format('d.m.Y') }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Datum odlaska:</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($reservation['departure_date'])->format('d.m.Y') }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Broj dana:</span>
            <span class="detail-value">{{ $reservation['num_of_days'] }} dana</span>
        </div>

        <div class="total-price">
            💰 Ukupna cena: {{ number_format($reservation['total_price'], 2) }} RSD
        </div>
    </div>

    @if(isset($reservation['payment_details']))
        <div class="payment-info">
            <h3 style="margin-top: 0;">💳 Potvrda Plaćanja</h3>
            <p><strong>Status:</strong> Plaćanje uspešno izvršeno</p>

            <div class="detail-row">
                <span class="detail-label">ID transakcije:</span>
                <span class="detail-value">{{ $reservation['payment_details']['ws_pay_order_id'] }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Datum plaćanja:</span>
                <span class="detail-value">{{ $reservation['payment_details']['payment_date'] }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Plaćeni iznos:</span>
                <span class="detail-value">{{ number_format($reservation['payment_details']['payment_amount'], 2) }} RSD</span>
            </div>
        </div>
    @endif

    @if(!empty($reservation['additional_info']))
        <div class="info-box">
            <h4 style="margin-top: 0;">📝 Vaše napomene:</h4>
            <p style="margin: 0;">{{ $reservation['additional_info'] }}</p>
        </div>
    @endif

    <div class="info-box">
        <h3 style="margin-top: 0; color: #667eea;">ℹ️ Šta je sledeće?</h3>
        <ol style="margin: 10px 0; padding-left: 20px;">
            <li>Naš tim će Vas kontaktirati u najkraćem roku na navedeni broj telefona</li>
            <li>Potvrdićemo sve detalje Vaše rezervacije</li>
            <li>Dobićete dodatne instrukcije o dolasku na parking</li>
            <li>Priprema Vašeg parking mesta biće završena do datuma dolaska</li>
        </ol>
    </div>

    <div class="contact-info">
        <h3 style="margin-top: 0; color: #667eea;">📞 Kontakt Informacije</h3>
        <p>Ukoliko imate bilo kakvih pitanja, slobodno nas kontaktirajte:</p>
        <p>
            <strong>Telefon:</strong> <a href="tel:+381694454255">+381 69 445 4255</a><br>
            <strong>Email:</strong> <a href="mailto:rezervacije@aeroparking.rs">rezervacije@aeroparking.rs</a>
        </p>
        <p style="margin-top: 20px;">
            <strong>Radno vreme:</strong><br>
            Dostupni smo 24/7 za sve Vaše potrebe
        </p>
    </div>

    <div style="background: #e7f3ff; padding: 15px; border-radius: 8px; text-align: center;">
        <p style="margin: 0; font-weight: bold; color: #0056b3;">
            🚗 Bezbedno i sigurno parkiranje uz najbolju uslugu! 🚗
        </p>
    </div>
</div>

<div class="footer">
    <p><strong>Aeroparking</strong></p>
    <p>Profesionalni parking servis u blizini aerodroma</p>
    <p style="margin-top: 15px; font-size: 12px; color: #999;">
        Ovo je automatska poruka. Molimo Vas da ne odgovarate direktno na ovaj email.<br>
        Za sva pitanja, koristite kontakt informacije navedene iznad.
    </p>
    <p style="font-size: 12px; color: #999;">
        © {{ date('Y') }} Aeroparking. Sva prava zadržana.
    </p>
</div>
</body>
</html>
