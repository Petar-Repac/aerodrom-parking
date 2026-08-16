<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.payment.subject_confirmation', ['id' => $reservation['reservation_id']]) }}</title>
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
        .note {
            font-size: 13px;
            color: #777;
            font-style: italic;
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

    <p class="greeting">{{ __('messages.payment.greeting', ['name' => $reservation['name']]) }}</p>
    <p>{{ __('messages.payment.thank_you_title') }}</p>
    <p>
        @if($reservation['payment_method'] === 'payment-online')
            {{ __('messages.payment.thank_you_message_paid') }}
        @else
            {{ __('messages.payment.thank_you_message') }}
        @endif
    </p>

    <div class="card">
        <h2 class="section-title">{{ __('messages.payment.your_reservation') }}</h2>
        <div class="row">
            <span class="label">{{ __('messages.payment.reservation_number') }}</span>
            <span class="value">{{ $reservation['reservation_id'] }}</span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.payment.name') }}</span>
            <span class="value">{{ $reservation['name'] }}</span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.payment.email') }}</span>
            <span class="value">{{ $reservation['email'] }}</span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.payment.phone') }}</span>
            <span class="value">{{ $reservation['phone'] }}</span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.payment.passengers') }}</span>
            <span class="value">{{ $reservation['passengers'] }}</span>
        </div>
    </div>

    <div class="card">
        <h2 class="section-title">{{ __('messages.payment.reservation_details') }}</h2>
        <div class="row">
            <span class="label">{{ __('messages.payment.arrival') }}</span>
            <span class="value">
                {{ \Carbon\Carbon::parse($reservation['arrival_date'])->format('d.m.Y') }}
                @if(!empty($reservation['arrival_time']))
                    {{ __('messages.payment.at') }} {{ $reservation['arrival_time'] }}
                @endif
            </span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.payment.departure') }}</span>
            <span class="value">
                {{ \Carbon\Carbon::parse($reservation['departure_date'])->format('d.m.Y') }}
                @if(!empty($reservation['departure_time']))
                    {{ __('messages.payment.around') }} {{ $reservation['departure_time'] }}
                @endif
            </span>
        </div>
        <div class="row">
            <span class="label">{{ __('messages.payment.duration') }}</span>
            <span class="value">{{ $reservation['num_of_days'] }} {{ __('messages.payment.days') }}</span>
        </div>
        <p class="note">{{ __('messages.payment.duration_note') }}</p>
    </div>

    <div class="card">
        <h2 class="section-title">{{ __('messages.payment.transfer_heading') }}</h2>
        <p>{{ __('messages.payment.transfer_text', ['passengers' => $reservation['passengers']]) }}</p>
        <p><strong>{{ __('messages.payment.transfer_recommendation') }}</strong></p>
    </div>

    <div class="card">
        <h2 class="section-title">{{ __('messages.payment.payment_information') }}</h2>

        @if($reservation['payment_method'] === 'payment-online')
            <div class="row">
                <span class="label">{{ __('messages.payment.status_label') }}</span>
                <span class="value">{{ __('messages.payment.payment_completed_status') }}</span>
            </div>
            <div class="row">
                <span class="label">{{ __('messages.payment.amount_paid_label') }}</span>
                <span class="value">{{ number_format($reservation['total_price'], 2, ',', '.') }} RSD</span>
            </div>
            @if(!empty($reservation['ws_pay_order_id']))
                <div class="row">
                    <span class="label">{{ __('messages.payment.transaction_id') }}</span>
                    <span class="value">{{ $reservation['ws_pay_order_id'] }}</span>
                </div>
            @endif
            @if(!empty($reservation['approval_code']))
                <div class="row">
                    <span class="label">{{ __('messages.payment.approval_code') }}</span>
                    <span class="value">{{ $reservation['approval_code'] }}</span>
                </div>
            @endif
            @if(!empty($reservation['payment_date']))
                <div class="row">
                    <span class="label">{{ __('messages.payment.payment_date') }}</span>
                    <span class="value">{{ \Carbon\Carbon::parse($reservation['payment_date'])->setTimezone('Europe/Belgrade')->format('d.m.Y H:i') }}</span>
                </div>
            @endif
        @else
            <div class="row">
                <span class="label">{{ __('messages.payment.payment_method_label') }}</span>
                <span class="value">{{ __('messages.payment.pay_onsite_value') }}</span>
            </div>
            <div class="row">
                <span class="label">{{ __('messages.payment.amount_due_label') }}</span>
                <span class="value">{{ number_format($reservation['total_price'], 2, ',', '.') }} RSD</span>
            </div>
            <p class="note">{{ __('messages.payment.accepted_payment_methods') }}</p>
        @endif
    </div>

    @if($reservation['payment_method'] === 'payment-online')
        <div class="card">
            <h2 class="section-title">{{ __('messages.payment.cancellation_heading') }}</h2>
            <p><strong>{{ __('messages.payment.free_cancellation_label') }}:</strong> {{ __('messages.payment.free_cancellation_text') }}</p>
            <p><strong>{{ __('messages.payment.no_show_label') }}:</strong> {{ __('messages.payment.no_show_text') }}</p>
        </div>
    @endif

    @if(!empty($reservation['additional_info']))
        <div class="card">
            <h2 class="section-title">{{ __('messages.payment.notes_title') }}</h2>
            <p>{{ $reservation['additional_info'] }}</p>
        </div>
    @endif

    <div class="card">
        <h2 class="section-title">{{ __('messages.payment.directions_heading') }}</h2>
        <p><strong>{{ __('messages.payment.address_label') }}:</strong> {{ __('messages.payment.address_value') }}</p>
        <p><a href="https://www.google.com/maps/search/?api=1&query=Sremskih+Partizana+133%2C+Sur%C4%8Din" target="_blank">{{ __('messages.payment.maps_link_text') }}</a></p>
    </div>

    <div class="card">
        <h2 class="section-title">{{ __('messages.payment.contact_info_title') }}</h2>
        <p>{{ __('messages.payment.contact_intro') }}</p>
        <p>
            <strong>{{ __('messages.payment.phone') }}:</strong> <a href="tel:+381694454255">+381 69 445 4255</a><br>
            <strong>Email:</strong> <a href="mailto:rezervacije@aeroparking.rs">rezervacije@aeroparking.rs</a>
        </p>
        <p style="margin-top: 16px;">
            <strong>{{ __('messages.payment.working_hours_label') }}</strong><br>
            {{ __('messages.payment.available_247') }}
        </p>
    </div>

    <hr class="divider">
    <div class="footer">
        <p>{{ __('messages.payment.footer_auto_notice') }}</p>
        <p>&copy; {{ date('Y') }} Aeroparking. {{ __('messages.payment.footer_rights') }}</p>
    </div>
</div>
</body>
</html>
