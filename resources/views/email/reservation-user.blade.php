<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.payment.subject_confirmation') }}</title>
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
    <h1>✅ {{ __('messages.payment.reservation_details') }}</h1>
    <p style="margin: 5px 0 0 0; font-size: 16px;">Aeroparking - Parking servis</p>
</div>

<div class="content">
    <div class="success-message">
        <h2 style="margin: 0 0 10px 0; color: #155724;">{{ __('messages.payment.thank_you_title') }}</h2>
        <p style="margin: 0;">{{ __('messages.payment.thank_you_message') }}</p>
    </div>

    <div class="reservation-details">
        <h3 style="margin-top: 0; color: #667eea;">📋 {{ __('messages.payment.your_reservation') }}</h3>

        <div class="detail-row">
            <span class="detail-label">{{ __('messages.payment.reservation_number') }}:</span>
            <span class="detail-value">{{ $reservation['reservation_id'] }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">{{ __('messages.payment.name') }}:</span>
            <span class="detail-value">{{ $reservation['name'] }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">{{ __('messages.payment.email') }}:</span>
            <span class="detail-value">{{ $reservation['email'] }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">{{ __('messages.payment.phone') }}:</span>
            <span class="detail-value">{{ $reservation['phone'] }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">{{ __('messages.payment.passengers') }}:</span>
            <span class="detail-value">{{ $reservation['passengers'] }}</span>
        </div>
    </div>

    <div class="reservation-details">
        <h3 style="margin-top: 0; color: #667eea;">📅 {{ __('messages.payment.reservation_details') }}</h3>

        <div class="detail-row">
            <span class="detail-label">{{ __('messages.payment.arrival') }}:</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($reservation['arrival_date'])->format('d.m.Y') }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">{{ __('messages.payment.departure') }}:</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($reservation['departure_date'])->format('d.m.Y') }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">{{ __('messages.payment.duration') }}:</span>
            <span class="detail-value">{{ $reservation['num_of_days'] }} {{ __('messages.payment.days') }}</span>
        </div>

        <div class="total-price">
            💰 {{ __('messages.payment.total_amount_with_vat') }}: {{ number_format($reservation['total_price'], 2, ',', '.') }} RSD
        </div>
    </div>

    @if(isset($reservation['ws_pay_order_id']) && $reservation['ws_pay_order_id'])
        <div class="payment-info">
            <h3 style="margin-top: 0;">💳 {{ __('messages.payment.payment_information') }}</h3>
            <p><strong>Status:</strong> {{ __('messages.payment.payment_completed_status') }}</p>

            <div class="detail-row">
                <span class="detail-label">{{ __('messages.payment.transaction_id') }}:</span>
                <span class="detail-value">{{ $reservation['ws_pay_order_id'] }}</span>
            </div>

            @if(isset($reservation['approval_code']) && $reservation['approval_code'])
            <div class="detail-row">
                <span class="detail-label">{{ __('messages.payment.approval_code') }}:</span>
                <span class="detail-value">{{ $reservation['approval_code'] }}</span>
            </div>
            @endif

            @if(isset($reservation['payment_date']) && $reservation['payment_date'])
            <div class="detail-row">
                <span class="detail-label">{{ __('messages.payment.payment_date') }}:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($reservation['payment_date'])->setTimezone('Europe/Belgrade')->format('d.m.Y H:i') }}</span>
            </div>
            @endif

            @if(isset($reservation['payment_amount']) && $reservation['payment_amount'])
            <div class="detail-row">
                <span class="detail-label">{{ __('messages.payment.total_amount_with_vat') }}:</span>
                <span class="detail-value">{{ number_format($reservation['payment_amount'], 2, ',', '.') }} RSD</span>
            </div>
            @endif
        </div>
    @endif

    @if(!empty($reservation['additional_info']))
        <div class="info-box">
            <h4 style="margin-top: 0;">📝 {{ __('messages.payment.notes_title') }}:</h4>
            <p style="margin: 0;">{{ $reservation['additional_info'] }}</p>
        </div>
    @endif

    <div class="info-box">
        <h3 style="margin-top: 0; color: #667eea;">ℹ️ {{ __('messages.payment.next_steps_title') }}</h3>
        <ol style="margin: 10px 0; padding-left: 20px;">
            <li>{{ __('messages.payment.next_step_contact') }}</li>
            <li>{{ __('messages.payment.next_step_confirm') }}</li>
            <li>{{ __('messages.payment.next_step_instructions') }}</li>
            <li>{{ __('messages.payment.next_step_prepare') }}</li>
        </ol>
    </div>

    <div class="contact-info">
        <h3 style="margin-top: 0; color: #667eea;">📞 {{ __('messages.payment.contact_info_title') }}</h3>
        <p>{{ __('messages.payment.contact_intro') }}</p>
        <p>
            <strong>{{ __('messages.payment.phone') }}:</strong> <a href="tel:+381694454255">+381 69 445 4255</a><br>
            <strong>Email:</strong> <a href="mailto:rezervacije@aeroparking.rs">rezervacije@aeroparking.rs</a>
        </p>
        <p style="margin-top: 20px;">
            <strong>{{ __('messages.payment.working_hours_label') }}</strong><br>
            {{ __('messages.payment.available_247') }}
        </p>
    </div>

    <div style="background: #e7f3ff; padding: 15px; border-radius: 8px; text-align: center;">
        <p style="margin: 0; font-weight: bold; color: #0056b3;">
            🚗 {{ __('messages.payment.safe_parking_message') }} 🚗
        </p>
    </div>
</div>

<div class="footer">
    <p><strong>Aeroparking</strong></p>
    <p>{{ __('messages.payment.footer_tagline') }}</p>
    <p style="margin-top: 15px; font-size: 12px; color: #999;">
        {{ __('messages.payment.footer_auto_notice') }}
    </p>
    <p style="font-size: 12px; color: #999;">
        © {{ date('Y') }} Aeroparking. {{ __('messages.payment.footer_rights') }}
    </p>
</div>
</body>
</html>
