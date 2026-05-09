<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neuspešno Plaćanje - Aeroparking</title>
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
        .error-message {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
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
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        .info-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
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
    </style>
</head>
<body>
<div class="header">
    <h1>❌ Neuspešno Plaćanje</h1>
    <p style="margin: 5px 0 0 0; font-size: 16px;">Aeroparking - Parking servis</p>
</div>

<div class="content">
    <div class="error-message">
        <h2 style="margin: 0 0 10px 0; color: #721c24;">Transakcija je neuspešna</h2>
        <p style="margin: 0;"><strong>Račun platne kartice nije zadužen.</strong></p>
        <p style="margin: 8px 0 0 0;">Nažalost, Vaše plaćanje nije moglo biti obrađeno. Molimo pokušajte ponovo ili nas kontaktirajte.</p>
    </div>

    <div class="reservation-details">
        <h3 style="margin-top: 0; color: #dc3545;">📋 Podaci o Rezervaciji</h3>

        <div class="detail-row">
            <span class="detail-label">Broj rezervacije:</span>
            <span class="detail-value">{{ $reservation['reservation_id'] }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Ime i prezime:</span>
            <span class="detail-value">{{ $reservation['name'] }}</span>
        </div>

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
            Ukupno sa PDV-om: {{ number_format($reservation['total_price'], 2, ',', '.') }} RSD
        </div>
    </div>

    <div class="info-box">
        <h3 style="margin-top: 0; color: #856404;">⚠️ Šta možete da uradite:</h3>
        <ol style="margin: 10px 0; padding-left: 20px;">
            <li>Proverite da li su podaci o kartici tačni i pokušajte ponovo</li>
            <li>Pokušajte ponovo za nekoliko minuta</li>
            <li>Kontaktirajte svoju banku radi provere</li>
            <li>Izaberite plaćanje na licu mesta pri dolasku na parking</li>
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
