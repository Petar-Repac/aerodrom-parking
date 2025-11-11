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
                <div class="payment-error-card">
                    <div class="error-icon">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>

                    <h1 class="text-center mb-4">{{ __('messages.payment.error_title') }}</h1>

                    <div class="alert alert-danger text-center">
                        <p class="mb-0">{{ __('messages.payment.error_message') }}</p>
                    </div>

                    @if(isset($error['error_message']))
                    <div class="error-details mt-3">
                        <div class="alert alert-warning">
                            <strong>{{ __('messages.payment.error_details') }}:</strong> {{ $error['error_message'] }}
                        </div>
                    </div>
                    @endif

                    @if(isset($reservation))
                    <div class="reservation-summary mt-4">
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
                            <span class="detail-label">{{ __('messages.payment.email') }}:</span>
                            <span class="detail-value">{{ $reservation['email'] }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="help-message mt-4">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <div>
                                <p class="mb-2">{{ __('messages.payment.error_help') }}</p>
                                <ul class="mb-0">
                                    <li>{{ __('messages.payment.try_again_later') }}</li>
                                    <li>{{ __('messages.payment.check_card_details') }}</li>
                                    <li>{{ __('messages.payment.contact_bank') }}</li>
                                    <li>{{ __('messages.payment.choose_onsite_payment') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="action-buttons mt-4">
                        <a href="{{ route('home') }}#reservation-form" class="btn btn-primary btn-lg">
                            <i class="bi bi-arrow-repeat"></i>
                            {{ __('messages.payment.try_again') }}
                        </a>

                        <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-house"></i>
                            {{ __('messages.payment.back_to_home') }}
                        </a>
                    </div>

                    <div class="contact-info mt-4 text-center">
                        <p class="mb-2">{{ __('messages.payment.need_help') }}</p>
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
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-10px);
            }
            75% {
                transform: translateX(10px);
            }
        }

        .reservation-summary {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
        }

        .reservation-summary h3 {
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

        .help-message .alert {
            display: flex;
            align-items: start;
            gap: 1rem;
        }

        .help-message i {
            font-size: 1.5rem;
            margin-top: 0.25rem;
        }

        .help-message ul {
            padding-left: 1.5rem;
        }

        .help-message li {
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
