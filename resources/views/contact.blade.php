<!DOCTYPE html>
<html lang="sr">
@include('partials.head.head')
<body>

<!-- ======= Header ======= -->
@include('partials.common.header')

<main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="kontakt" class="contact">
        <div class="container">
            <div class="section-title">
                <h3>Kontakt</h3>
            </div>
            <div class="map-div">
                <iframe style="border:0; width: 100%; height: 470px;" title="google maps"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11323.4418740816!2d20.300839014691345!3d44.804032171070865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a6987e5962bc9%3A0x83125938d680c6f2!2sAerodromski%20parking!5e0!3m2!1ssr!2srs!4v1713703011247!5m2!1ssr!2srs"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="row mt-5">
                <div class="col-lg-4">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Lokacija:</h4>
                            <p>Put za aerodrom bb, Београд 11271</p>
                        </div>

                        <div class="email">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p>rezervacije@aeroparking.rs</p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Telefon:</h4>
                            <p>+381 69 445 4255</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="contact-form-container">
                        <h3 class="mb-4">Pošaljite nam poruku</h3>

                        <form action="{{ route('contact.send') }}" method="post" role="form" class="php-email-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="name">Ime i prezime *</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Vaše ime i prezime" required value="{{ old('name') }}">
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <label for="email">Email adresa *</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="vaš@email.com" required value="{{ old('email') }}">
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6 form-group">
                                    <label for="phone">Telefon</label>
                                    <input type="tel" class="form-control" name="phone" id="phone" placeholder="+381 69 445 4255" value="{{ old('phone') }}">
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="subject">Naslov poruke *</label>
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Ukratko opišite razlog kontakta" required value="{{ old('subject') }}">
                                @error('subject')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="message">Poruka *</label>
                                <textarea class="form-control" name="message" id="message" rows="6" placeholder="Detaljno opišite vaš upit ili potrebu..." required>{{ old('message') }}</textarea>
                                @error('message')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Pošaljite poruku
                                </button>
                            </div>
                        </form>
                    </div>
                </div><!-- End Contact Form -->
            </div>
        </div>
    </section><!-- End Contact Section -->

    @include('partials.page-sections.cta')
</main><!-- End #main -->

@include('partials.common.footer')

@include('partials.common.reservation-drawer')

<!-- Toast Notification -->
<div id="toast-notification" class="toast-notification">
    <div class="toast-content">
        <div class="toast-icon">
            <i class="fas fa-check-circle" id="toast-icon"></i>
        </div>
        <div class="toast-text">
            <div class="toast-title" id="toast-title">Uspešno poslato!</div>
            <div class="toast-message" id="toast-message">Vaša poruka je poslata na e-mail!</div>
        </div>
        <button class="toast-close" onclick="closeToast()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="toast-progress" id="toast-progress"></div>
</div>

@include('partials.common.scripts-homepage')

<style>
    /* Contact Form Styles */
    .contact-form-container {
        background: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .php-email-form label {
        font-weight: 500;
        margin-bottom: 5px;
        color: #333;
    }

    .php-email-form .form-control {
        border: 2px solid #eee;
        border-radius: 5px;
        padding: 12px;
        transition: border-color 0.3s ease;
    }

    .php-email-form .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .php-email-form .btn-primary {
        background: #007bff;
        border: none;
        padding: 12px 30px;
        border-radius: 5px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .php-email-form .btn-primary:hover {
        background: #0056b3;
        transform: translateY(-2px);
    }

    /* Toast Notification Styles */
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border-left: 4px solid #007bff;
        min-width: 320px;
        max-width: 400px;
        z-index: 9999;
        display: none;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
    }

    .toast-notification.show {
        display: block;
        opacity: 1;
        transform: translateX(0);
    }

    .toast-notification.success {
        border-left-color: #10b981;
    }

    .toast-notification.error {
        border-left-color: #ef4444;
    }

    .toast-notification.warning {
        border-left-color: #f59e0b;
    }

    .toast-notification.info {
        border-left-color: #007bff;
    }

    .toast-content {
        display: flex;
        align-items: flex-start;
        padding: 16px;
        gap: 12px;
    }

    .toast-icon {
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 2px;
    }

    .toast-icon i {
        font-size: 20px;
    }

    .toast-notification.success .toast-icon i {
        color: #10b981;
    }

    .toast-notification.error .toast-icon i {
        color: #ef4444;
    }

    .toast-notification.warning .toast-icon i {
        color: #f59e0b;
    }

    .toast-notification.info .toast-icon i {
        color: #007bff;
    }

    .toast-text {
        flex: 1;
        min-width: 0;
    }

    .toast-title {
        font-weight: 600;
        font-size: 14px;
        color: #333;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .toast-message {
        font-size: 13px;
        color: #666;
        line-height: 1.4;
        word-wrap: break-word;
    }

    .toast-close {
        flex-shrink: 0;
        background: none;
        border: none;
        padding: 4px;
        cursor: pointer;
        color: #9ca3af;
        transition: color 0.2s ease;
        margin-top: -2px;
    }

    .toast-close:hover {
        color: #333;
    }

    .toast-close i {
        font-size: 14px;
    }

    .toast-progress {
        height: 3px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 0 0 6px 6px;
        overflow: hidden;
        position: relative;
    }

    .toast-progress::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: #007bff;
        width: 100%;
        transform: scaleX(0);
        transform-origin: left;
        animation: toast-progress 5s linear forwards;
    }

    .toast-notification.success .toast-progress::before {
        background: #10b981;
    }

    .toast-notification.error .toast-progress::before {
        background: #ef4444;
    }

    .toast-notification.warning .toast-progress::before {
        background: #f59e0b;
    }

    @keyframes toast-progress {
        to {
            transform: scaleX(1);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .toast-notification {
            right: 10px;
            left: 10px;
            min-width: auto;
            max-width: none;
        }

        .contact-form-container {
            padding: 20px;
        }
    }

    @media (max-width: 480px) {
        .toast-notification {
            top: 10px;
            right: 10px;
            left: 10px;
        }

        .toast-content {
            padding: 12px;
        }

        .toast-title {
            font-size: 13px;
        }

        .toast-message {
            font-size: 12px;
        }
    }
</style>

<script>
    // Toast Notification Functions
    let toastTimeout;

    function showToastNotification(title, message, type = 'success') {
        const toast = document.getElementById('toast-notification');
        const toastTitle = document.getElementById('toast-title');
        const toastMessage = document.getElementById('toast-message');
        const toastIcon = document.getElementById('toast-icon');

        if (!toast) {
            console.error('Toast notification element not found');
            alert(`${title}: ${message}`);
            return;
        }

        // Clear any existing timeout
        if (toastTimeout) {
            clearTimeout(toastTimeout);
        }

        // Remove all type classes
        toast.classList.remove('success', 'error', 'warning', 'info');

        // Set content
        toastTitle.textContent = title;
        toastMessage.textContent = message;

        // Set icon based on type
        let iconClass = 'fas fa-check-circle';
        switch(type) {
            case 'error':
                iconClass = 'fas fa-exclamation-circle';
                break;
            case 'warning':
                iconClass = 'fas fa-exclamation-triangle';
                break;
            case 'info':
                iconClass = 'fas fa-info-circle';
                break;
            default:
                iconClass = 'fas fa-check-circle';
        }

        toastIcon.className = iconClass;
        toast.classList.add(type);

        // Show toast with animation
        toast.style.display = 'block';

        // Force reflow to ensure display: block is applied
        toast.offsetHeight;

        toast.classList.add('show');

        // Auto hide after 5 seconds
        toastTimeout = setTimeout(() => {
            hideToast();
        }, 5000);
    }

    function hideToast() {
        const toast = document.getElementById('toast-notification');
        if (toast) {
            toast.classList.remove('show');

            // Hide completely after animation
            setTimeout(() => {
                toast.style.display = 'none';
            }, 300);
        }
    }

    function closeToast() {
        if (toastTimeout) {
            clearTimeout(toastTimeout);
        }
        hideToast();
    }

    // Contact form script
    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.querySelector('.php-email-form');

        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitButton = contactForm.querySelector('button[type="submit"]');
                const loadingDiv = contactForm.querySelector('.loading');
                const errorDiv = contactForm.querySelector('.error-message');
                const successDiv = contactForm.querySelector('.sent-message');

                // Reset previous states
                if (loadingDiv) loadingDiv.style.display = 'block';
                if (errorDiv) errorDiv.style.display = 'none';
                if (successDiv) successDiv.style.display = 'none';

                // Clear previous validation errors
                contactForm.querySelectorAll('.text-danger').forEach(el => {
                    el.textContent = '';
                });

                // Disable submit button
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Šalje se...';
                }

                // Get form data
                const formData = new FormData(contactForm);

                // Get CSRF token
                const csrfToken = contactForm.querySelector('input[name="_token"]');

                // Send form data via fetch
                fetch(contactForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken ? csrfToken.value : '',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(response => {
                        return response.json().then(data => ({
                            status: response.status,
                            data: data
                        }));
                    })
                    .then(({status, data}) => {
                        // Hide loading
                        if (loadingDiv) loadingDiv.style.display = 'none';

                        // Re-enable submit button
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.innerHTML = '<i class="fas fa-paper-plane"></i> Pošaljite poruku';
                        }

                        if (status === 200 && data.success) {
                            // Show success message
                            showToastNotification('Uspešno poslato!', 'Vaša poruka je uspešno poslata. Hvala vam!', 'success');

                            if (successDiv) {
                                successDiv.textContent = 'Vaša poruka je poslata. Hvala vam!';
                                successDiv.style.display = 'block';
                            }

                            // Reset form
                            contactForm.reset();
                        } else {
                            // Handle validation errors
                            if (data.errors) {
                                Object.keys(data.errors).forEach(field => {
                                    const errorElement = contactForm.querySelector(`input[name="${field}"] + .text-danger, select[name="${field}"] + .text-danger, textarea[name="${field}"] + .text-danger`);
                                    if (errorElement) {
                                        errorElement.textContent = data.errors[field][0];
                                    }
                                });
                                showToastNotification('Greška u formi', 'Molimo ispravite greške u formi i pokušajte ponovo.', 'error');
                            } else {
                                showToastNotification('Greška', data.message || 'Došlo je do greške. Molimo pokušajte ponovo.', 'error');
                            }

                            if (errorDiv) {
                                errorDiv.textContent = data.message || 'Došlo je do greške. Molimo pokušajte ponovo.';
                                errorDiv.style.display = 'block';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // Hide loading
                        if (loadingDiv) loadingDiv.style.display = 'none';

                        // Re-enable submit button
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.innerHTML = '<i class="fas fa-paper-plane"></i> Pošaljite poruku';
                        }

                        // Show error notification
                        showToastNotification('Greška', 'Došlo je do greške prilikom slanja poruke. Molimo pokušajte ponovo.', 'error');

                        if (errorDiv) {
                            errorDiv.textContent = 'Došlo je do greške prilikom slanja poruke. Molimo pokušajte ponovo.';
                            errorDiv.style.display = 'block';
                        }
                    });
            });
        }
    });
</script>

</body>
</html>
