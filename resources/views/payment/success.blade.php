<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('partials.head.head')
<body>


<!-- ======= Header ======= -->
@include('partials.common.header')

<main id="main">
    <div class="container payment-result-page">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-lg-8">
                <div class="payment-success-card">
                    <div class="success-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <h1 class="text-center mb-4">{{ __('messages.payment.success_title') }}</h1>

                    <div class="alert alert-success text-center">
                        <p class="mb-0">{{ __('messages.payment.success_message') }}</p>
                    </div>

                    @if(isset($reservation))
                        <div class="reservation-details mt-4">
                            <h3 class="mb-3">{{ __('messages.payment.reservation_details') }}</h3>

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

                            <div class="detail-row total-price">
                                <span class="detail-label">{{ __('messages.payment.total_amount_with_vat') }}:</span>
                                <span class="detail-value">{{ number_format($reservation['total_price'], 2, ',', '.') }} RSD</span>
                            </div>

                            @if(isset($reservation['ws_pay_order_id']) && $reservation['ws_pay_order_id'])
                                <div class="payment-info mt-3">
                                    <h4>{{ __('messages.payment.payment_information') }}</h4>

                                    <div class="detail-row">
                                        <span class="detail-label">{{ __('messages.payment.transaction_id') }}:</span>
                                        <span class="detail-value">{{ $reservation['ws_pay_order_id'] }}</span>
                                    </div>

                                    <div class="detail-row">
                                        <span class="detail-label">{{ __('messages.payment.approval_code') }}:</span>
                                        <span class="detail-value">{{ $reservation['approval_code'] }}</span>
                                    </div>

                                    <div class="detail-row">
                                        <span class="detail-label">{{ __('messages.payment.payment_date') }}:</span>
                                        <span class="detail-value">
                                            @if($reservation['payment_date'])
                                                {{ \Carbon\Carbon::parse($reservation['payment_date'])->format('d.m.Y H:i') }}
                                            @else
                                                —
                                            @endif
                                        </span>
                                    </div>

                                    @if(isset($reservation['credit_card_number']) && $reservation['credit_card_number'])
                                        <div class="detail-row">
                                            <span class="detail-label">{{ __('messages.payment.card_number') }}:</span>
                                            <span class="detail-value">**** **** **** {{ substr($reservation['credit_card_number'], -4) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="confirmation-message mt-4">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                {{ __('messages.payment.confirmation_email_sent') }}
                            </div>
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ \App\Helpers\RouteHelper::localizedRoute('home') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-house"></i>
                            {{ __('messages.payment.back_to_home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .payment-result-page {
            padding: 2rem 0;
        }

        .payment-success-card {
            background: white;
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .success-icon {
            text-align: center;
            margin-bottom: 2rem;
        }

        .success-icon i {
            font-size: 5rem;
            color: #28a745;
            animation: successPulse 2s ease-in-out infinite;
        }

        @keyframes successPulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        .reservation-details {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
        }

        .reservation-details h3,
        .payment-info h4 {
            color: #333;
            margin-bottom: 1rem;
            border-bottom: 2px solid #007bff;
            padding-bottom: 0.5rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #dee2e6;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #666;
        }

        .detail-value {
            color: #333;
            text-align: right;
        }

        .total-price {
            background: #e7f3ff;
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .payment-info {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-top: 1rem;
        }

        .confirmation-message .alert {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .confirmation-message i {
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .payment-success-card {
                padding: 1.5rem;
            }

            .detail-row {
                flex-direction: column;
                gap: 0.25rem;
            }

            .detail-value {
                text-align: left;
            }
        }
    </style>
</main><!-- End #main -->

@include('partials.common.footer')

@include('partials.common.reservation-drawer')

@include('partials.common.scripts-homepage')

{{--@include('partials.util.theme-customizer')--}}
</body>

</html>
