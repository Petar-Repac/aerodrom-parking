<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.payment.subject_failed') }}</title>
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
    <h1>❌ {{ __('messages.payment.error_title') }}</h1>
    <p style="margin: 5px 0 0 0; font-size: 16px;">Aeroparking - Parking servis</p>
</div>

<div class="content">
    <div class="error-message">
        <h2 style="margin: 0 0 10px 0; color: #721c24;">{{ __('messages.payment.failed_transaction_title') }}</h2>
        <p style="margin: 0;"><strong>{{ __('messages.payment.card_not_charged') }}</strong></p>
        <p style="margin: 8px 0 0 0;">{{ __('messages.payment.failed_intro_message') }}</p>
    </div>

    <div class="reservation-details">
        <h3 style="margin-top: 0; color: #dc3545;">📋 {{ __('messages.payment.reservation_details') }}</h3>

        <div class="detail-row">
            <span class="detail-label">{{ __('messages.payment.reservation_number') }}:</span>
            <span class="detail-value">{{ $reservation['reservation_id'] }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">{{ __('messages.payment.name') }}:</span>
            <span class="detail-value">{{ $reservation['name'] }}</span>
        </div>

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
            {{ __('messages.payment.total_amount_with_vat') }}: {{ number_format($reservation['total_price'], 2, ',', '.') }} RSD
        </div>
    </div>

    <div class="info-box">
        <h3 style="margin-top: 0; color: #856404;">⚠️ {{ __('messages.payment.error_help') }}</h3>
        <ol style="margin: 10px 0; padding-left: 20px;">
            <li>{{ __('messages.payment.check_card_details') }}</li>
            <li>{{ __('messages.payment.try_again_later') }}</li>
            <li>{{ __('messages.payment.contact_bank') }}</li>
            <li>{{ __('messages.payment.choose_onsite_payment') }}</li>
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
