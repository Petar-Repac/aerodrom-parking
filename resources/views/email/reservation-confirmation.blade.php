<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.reservation_confirmation.subject', ['id' => $reservation['reservation_id']]) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #2d2d3a;
            background: #f4f4f7;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 24px 16px;
        }
        .logo-row {
            text-align: center;
            padding: 8px 0 16px;
        }
        .logo-row img {
            width: 96px;
            height: auto;
        }
        .divider {
            border: none;
            border-top: 2px solid #742CCC;
            margin: 0 0 20px;
        }
        .card {
            background: #ffffff;
            border-radius: 10px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 4px;
        }
        h2.section-title {
            font-size: 18px;
            color: #4b1e8f;
            margin: 0 0 14px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .row:last-child {
            border-bottom: none;
        }
        .row .label {
            color: #666;
        }
        .row .value {
            font-weight: bold;
            color: #222;
            text-align: right;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 24px;
        }
        a {
            color: #742CCC;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="logo-row">
        <img src="{{ asset('img/email-logo.png') }}" alt="Aero Parking">
    </div>
    <hr class="divider">

    <p class="greeting">{{ __('messages.reservation_confirmation.greeting', ['name' => $reservation['name']]) }}</p>
    <p>{{ __('messages.reservation_confirmation.thank_you') }}</p>

    <div class="card">
        <h2 class="section-title">{{ __('messages.reservation_confirmation.your_reservation_heading') }}</h2>
        <div class="row">
            <span class="label">{{ __('messages.reservation_confirmation.reservation_number') }}: </span>
            <span class="value">{{ $reservation['reservation_id'] }}</span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.reservation_confirmation.name') }}: </span>
            <span class="value">{{ $reservation['name'] }}</span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.reservation_confirmation.email') }}: </span>
            <span class="value">{{ $reservation['email'] }}</span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.reservation_confirmation.phone') }}: </span>
            <span class="value">{{ $reservation['phone'] }}</span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.reservation_confirmation.passengers') }}: </span>
            <span class="value">{{ $reservation['passengers'] }}</span>
        </div>
    </div>

    <div class="card">
        <h2 class="section-title">{{ __('messages.reservation_confirmation.schedule_heading') }}</h2>
        <div class="row">
            <span class="label">{{ __('messages.reservation_confirmation.arrival') }}: </span>
            <span class="value">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $reservation['arrival_date'])->format('d.m.Y') }} {{ __('messages.reservation_confirmation.at') }} {{ $reservation['arrival_time'] }}</span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.reservation_confirmation.departure') }}: </span>
            <span class="value">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $reservation['departure_date'])->format('d.m.Y') }} {{ __('messages.reservation_confirmation.around') }} {{ $reservation['departure_time'] }}</span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.reservation_confirmation.duration') }}: </span>
            <span class="value">{{ $reservation['num_of_days'] }} {{ __('messages.reservation_confirmation.days') }} {{ __('messages.reservation_confirmation.duration_note') }}</span>
        </div>
    </div>

    <div class="card">
        <h2 class="section-title">{{ __('messages.reservation_confirmation.transfer_heading') }}</h2>
        <p>{{ __('messages.reservation_confirmation.transfer_text', ['passengers' => $reservation['passengers']]) }}</p>
        <p><strong>{{ __('messages.reservation_confirmation.transfer_recommendation') }}</strong></p>
    </div>

    <div class="card">
        <h2 class="section-title">{{ __('messages.reservation_confirmation.return_heading') }}</h2>
        <p>{{ __('messages.reservation_confirmation.return_text') }}</p>
    </div>

    <div class="card">
        <h2 class="section-title">{{ __('messages.reservation_confirmation.payment_heading') }}</h2>
        <div class="row">
            <span class="label">{{ __('messages.reservation_confirmation.payment_method_onsite') }}</span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.reservation_confirmation.amount_label') }}: </span>
            <span class="value">{{ $reservation['amount'] ?? '-' }} RSD</span>
        </div>
    </div>

    <div class="card">
        <h2 class="section-title">{{ __('messages.reservation_confirmation.cancellation_heading') }}</h2>
        <p>{{ __('messages.reservation_confirmation.cancellation_text') }}</p>
    </div>

    <div class="card">
        <h2 class="section-title">{{ __('messages.reservation_confirmation.directions_heading') }}</h2>
        <p><strong>{{ __('messages.reservation_confirmation.address_label') }}:</strong> {{ __('messages.reservation_confirmation.address_value') }}</p>
        <p><a href="https://www.google.com/maps/search/?api=1&query=Sremskih+Partizana+133%2C+Sur%C4%8Din" target="_blank">{{ __('messages.reservation_confirmation.maps_link_text') }}</a></p>
    </div>

    <div class="card">
        <h2 class="section-title">{{ __('messages.reservation_confirmation.contact_heading') }}</h2>
        <p>
            <strong>{{ __('messages.reservation_confirmation.phone') }}:</strong> <a href="tel:+381694454255">+381 69 445 4255</a><br>
            <strong>Email:</strong> <a href="mailto:rezervacije@aeroparking.rs">rezervacije@aeroparking.rs</a>
        </p>
    </div>

    <hr class="divider">
    <div class="footer">
        <p>{{ __('messages.reservation_confirmation.footer_auto_notice') }}</p>
        <p>&copy; {{ date('Y') }} Aero Parking</p>
    </div>
</div>
</body>
</html>
