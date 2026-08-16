<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Rezervacija - Aeroparking</title>
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
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
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
            padding: 10px 0;
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
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            margin: 10px 0;
        }
        .status-onsite {
            background: #28a745;
            color: white;
        }
        .status-paid {
            background: #007bff;
            color: white;
        }
        .status-failed {
            background: #dc3545;
            color: white;
        }
        .payment-info {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .alert-warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
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
    <h1>📧 Nova Rezervacija</h1>
    <p style="margin: 0;">Aeroparking - Rezervacioni Sistem</p>
</div>

<div class="content">
    @if($type === 'onsite')
        <h2>Rezervacija - Plaćanje na licu mesta</h2>
        <div class="status-badge status-onsite">PLAĆANJE NA LICU MESTA</div>
    @elseif($type === 'online_success')
        <h2>Rezervacija - Online plaćanje uspešno</h2>
        <div class="status-badge status-paid">PLAĆENO ONLINE</div>
    @elseif($type === 'online_failed')
        <h2>⚠️ Neuspelo plaćanje - Zahteva pažnju</h2>
        <div class="status-badge status-failed">NEUSPELO PLAĆANJE</div>
        <div class="alert alert-warning">
            <strong>Napomena:</strong> Korisnik je pokušao da plati online, ali plaćanje nije uspelo.
            Kontaktirajte klijenta da proverite da li želi da pokuša ponovo ili želi plaćanje na licu mesta.
        </div>
    @endif

    <div class="reservation-details">
        <h3>📋 Detalji Rezervacije</h3>

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

        <div class="detail-row">
            <span class="detail-label">Datum dolaska:</span>
            <span class="detail-value">
                {{ \Carbon\Carbon::parse($reservation['arrival_date'])->format('d.m.Y') }}
                @if(!empty($reservation['arrival_time']))
                    u {{ $reservation['arrival_time'] }}
                @endif
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Datum odlaska:</span>
            <span class="detail-value">
                {{ \Carbon\Carbon::parse($reservation['departure_date'])->format('d.m.Y') }}
                @if(!empty($reservation['departure_time']))
                    oko {{ $reservation['departure_time'] }}
                @endif
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Broj dana:</span>
            <span class="detail-value">{{ $reservation['num_of_days'] }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Ukupna cena:</span>
            <span class="detail-value"><strong>{{ number_format($reservation['total_price'], 2) }} RSD</strong></span>
        </div>

        @if(!empty($reservation['additional_info']))
            <div class="detail-row">
                <span class="detail-label">Dodatne informacije:</span>
                <span class="detail-value">{{ $reservation['additional_info'] }}</span>
            </div>
        @endif

        @if(isset($reservation['ws_pay_order_id']) && $reservation['ws_pay_order_id'])
            <div class="payment-info">
                <h4>💳 Informacije o plaćanju</h4>

                <div class="detail-row">
                    <span class="detail-label">ID transakcije:</span>
                    <span class="detail-value">{{ $reservation['ws_pay_order_id'] }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Kod odobrenja:</span>
                    <span class="detail-value">{{ $reservation['approval_code'] }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">STAN:</span>
                    <span class="detail-value">{{ $reservation['stan'] }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Datum plaćanja:</span>
                    <span class="detail-value">{{ $reservation['payment_date'] ? \Carbon\Carbon::parse($reservation['payment_date'])->setTimezone('Europe/Belgrade')->format('d.m.Y H:i') : '-' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Plaćeni iznos:</span>
                    <span class="detail-value">{{ number_format($reservation['payment_amount'], 2) }} RSD</span>
                </div>
            </div>
        @endif

        @if(isset($reservation['error_message']))
            <div class="alert alert-warning">
                <strong>Razlog neuspeha:</strong> {{ $reservation['error_message'] }}
            </div>
        @endif
    </div>

    <div style="background: #fff; padding: 15px; border-radius: 8px; margin-top: 20px;">
        <p><strong>Sledeći koraci:</strong></p>
        <ul>
            @if($type === 'onsite')
                <li>Kontaktirajte klijenta na navedeni broj telefona ili email</li>
                <li>Potvrdite rezervaciju i proverite sve detalje</li>
                <li>Dogovorite plaćanje na licu mesta</li>
            @elseif($type === 'online_success')
                <li>Plaćanje je uspešno izvršeno</li>
                <li>Kontaktirajte klijenta da potvrdite detalje</li>
                <li>Pripremite parking mesto za navedeni datum</li>
            @elseif($type === 'online_failed')
                <li>Hitno kontaktirajte klijenta</li>
                <li>Proverite razlog neuspeha plaćanja</li>
                <li>Ponudite alternativne opcije plaćanja</li>
            @endif
        </ul>
    </div>
</div>

<div class="footer">
    <p>Ovo je automatska poruka iz rezervacionog sistema Aeroparking</p>
    <p>Datum: {{ now('Europe/Belgrade')->format('d.m.Y H:i:s') }}</p>
</div>
</body>
</html>
