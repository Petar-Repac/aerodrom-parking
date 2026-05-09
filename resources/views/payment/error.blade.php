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
                <div class="payment-error-card">
                    <div class="error-icon">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>

                    <h1 class="text-center mb-4">{{ __('messages.payment.error_title') }}</h1>

                    <div class="alert alert-danger text-center">
                        <p class="mb-1"><strong>{{ __('messages.payment.transaction_failed_notice') }}</strong></p>
                        <p class="mb-0">{{ __('messages.payment.error_message') }}</p>
                    </div>

                    @if(isset($reservation))
                        <div class="reservation-details mt-4">
                            <h3 class="mb-3">{{ __('messages.payment.your_reservation') }}</h3>

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

                            <div class="detail-row total-price">
                                <span class="detail-label">{{ __('messages.payment.total_amount') }}:</span>
                                <span class="detail-value">{{ number_format($reservation['total_price'], 2, ',', '.') }} RSD</span>
                            </div>
                        </div>
                    @endif

                    <div class="error-help mt-4">
                        <h4>{{ __('messages.payment.error_help') }}</h4>
                        <ul>
                            <li>{{ __('messages.payment.check_card_details') }}</li>
                            <li>{{ __('messages.payment.try_again_later') }}</li>
                            <li>{{ __('messages.payment.contact_bank') }}</li>
                            <li>{{ __('messages.payment.choose_onsite_payment') }}</li>
                        </ul>
                    </div>

                    <div class="text-center mt-4 d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ \App\Helpers\RouteHelper::localizedRoute('home') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-arrow-clockwise"></i>
                            {{ __('messages.payment.try_again') }}
                        </a>
                        <a href="{{ \App\Helpers\RouteHelper::localizedRoute('home') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-house"></i>
                            {{ __('messages.payment.back_to_home') }}
                        </a>
                    </div>

                    <div class="text-center mt-3">
                        <p class="text-muted">
                            <i class="bi bi-headset"></i>
                            {{ __('messages.payment.need_help') }}
                            <a href="tel:+381694454255">+381 69 445 4255</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .payment-result-page {
            padding: 2rem 0;
        }

        .payment-error-card {
            background: white;
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .error-icon {
            text-align: center;
            margin-bottom: 2rem;
        }

        .error-icon i {
            font-size: 5rem;
            color: #dc3545;
        }

        .reservation-details {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
        }

        .reservation-details h3 {
            color: #333;
            margin-bottom: 1rem;
            border-bottom: 2px solid #dc3545;
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
            background: #fff3cd;
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .error-help {
            background: #fff3cd;
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid #ffc107;
        }

        .error-help h4 {
            color: #856404;
            margin-bottom: 1rem;
        }

        .error-help ul {
            margin: 0;
            padding-left: 1.5rem;
            color: #333;
        }

        .error-help ul li {
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .payment-error-card {
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

</body>

</html>
