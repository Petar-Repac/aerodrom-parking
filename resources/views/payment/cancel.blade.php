<!DOCTYPE html>
<html lang="sr">
@include('partials.head.head')
<body>


<!-- ======= Header ======= -->
@include('partials.common.header')

<main id="main">
    <div class="container payment-result-page">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-lg-8">
                <div class="payment-cancel-card">
                    <div class="cancel-icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>

                    <h1 class="text-center mb-4">{{ __('messages.payment.cancel_title') }}</h1>

                    <div class="alert alert-warning text-center">
                        <p class="mb-0">{{ __('messages.payment.cancel_message') }}</p>
                    </div>

                    @if(isset($reservation))
                    <div class="reservation-summary mt-4">
                        <h3 class="mb-3">{{ __('messages.payment.cancelled_reservation') }}</h3>

                        <div class="detail-row">
                            <span class="detail-label">{{ __('messages.payment.reservation_number') }}:</span>
                            <span class="detail-value">{{ $reservation['reservation_id'] }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">{{ __('messages.payment.name') }}:</span>
                            <span class="detail-value">{{ $reservation['name'] }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">{{ __('messages.payment.total_amount') }}:</span>
                            <span class="detail-value">{{ number_format($reservation['total_price'], 2) }} RSD</span>
                        </div>
                    </div>

                    <div class="info-message mt-4">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <div>
                                <p class="mb-2"><strong>{{ __('messages.payment.what_happens_now') }}</strong></p>
                                <ul class="mb-0">
                                    <li>{{ __('messages.payment.no_charge_made') }}</li>
                                    <li>{{ __('messages.payment.can_try_again') }}</li>
                                    <li>{{ __('messages.payment.or_choose_onsite') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="action-buttons mt-4">
                        <a href="{{ route('home') }}#reservation-form" class="btn btn-primary btn-lg">
                            <i class="bi bi-arrow-repeat"></i>
                            {{ __('messages.payment.complete_reservation') }}
                        </a>

                        <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-house"></i>
                            {{ __('messages.payment.back_to_home') }}
                        </a>
                    </div>

                    <div class="contact-info mt-4 text-center">
                        <p class="mb-2">{{ __('messages.payment.questions') }}</p>
                        <div class="contact-methods">
                            <a href="tel:+381694454255" class="contact-link">
                                <i class="bi bi-telephone"></i> +381 69 445 4255
                            </a>
                            <a href="mailto:rezervacije@aeroparking.rs" class="contact-link">
                                <i class="bi bi-envelope"></i> rezervacije@aeroparking.rs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .payment-result-page {
            padding: 2rem 0;
        }

        .payment-cancel-card {
            background: white;
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .cancel-icon {
            text-align: center;
            margin-bottom: 2rem;
        }

        .cancel-icon i {
            font-size: 5rem;
            color: #ffc107;
        }

        .reservation-summary {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
        }

        .reservation-summary h3 {
            color: #333;
            margin-bottom: 1rem;
            border-bottom: 2px solid #ffc107;
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

        .info-message .alert {
            display: flex;
            align-items: start;
            gap: 1rem;
        }

        .info-message i {
            font-size: 1.5rem;
            margin-top: 0.25rem;
        }

        .info-message ul {
            padding-left: 1.5rem;
        }

        .info-message li {
            margin-bottom: 0.5rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .action-buttons .btn {
            min-width: 200px;
        }

        .contact-methods {
            display: flex;
            gap: 2rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .contact-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .contact-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .payment-cancel-card {
                padding: 1.5rem;
            }

            .detail-row {
                flex-direction: column;
                gap: 0.25rem;
            }

            .detail-value {
                text-align: left;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn {
                width: 100%;
            }

            .contact-methods {
                flex-direction: column;
                gap: 1rem;
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
