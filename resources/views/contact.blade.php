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

            <!-- Map Section -->
            <div class="map-div">
                <iframe style="border:0; width: 100%; height: 470px;" title="google maps"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11323.4418740816!2d20.300839014691345!3d44.804032171070865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a6987e5962bc9%3A0x83125938d680c6f2!2sAerodromski%20parking!5e0!3m2!1ssr!2srs!4v1713703011247!5m2!1ssr!2srs"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <!-- Contact Form -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="contact-form-container">
                        <h3 class="mb-4">Pošaljite nam poruku</h3>

                        <form action="{{ route('contact.send') }}" method="post" role="form" class="php-email-form">
                            @csrf

                            <!-- Loading/Success/Error Messages -->
                            <div class="loading">Šalje se...</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Vaša poruka je poslata. Hvala vam!</div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="name">Ime i prezime *</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                           placeholder="Vaše ime i prezime" required value="{{ old('name') }}">
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="email">Email adresa *</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           placeholder="vaš@email.com" required value="{{ old('email') }}">
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="phone">Telefon</label>
                                    <input type="tel" class="form-control" name="phone" id="phone"
                                           placeholder="+381 69 445 4255" value="{{ old('phone') }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="subject">Naslov poruke *</label>
                                    <input type="text" class="form-control" name="subject" id="subject"
                                           placeholder="Ukratko opišite razlog kontakta" required value="{{ old('subject') }}">
                                    @error('subject')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message">Poruka *</label>
                                <textarea class="form-control" name="message" id="message" rows="6"
                                          placeholder="Detaljno opišite vaš upit ili potrebu..." required>{{ old('message') }}</textarea>
                                @error('message')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Pošaljite poruku
                                </button>
                            </div>
                        </form>
                    </div>
                </div><!-- End Contact Form -->
            </div>
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
    /* Contact Page Specific Styles */
    .contact {
        padding: 60px 0;
    }

    .contact .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Section Title */
    .contact .section-title {
        text-align: center;
        padding-top: 40px;
    }

    .contact .section-title h3 {
        font-size: 32px;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 20px;
    }

    .contact .section-title h3::after {
        content: "";
        position: absolute;
        display: block;
        width: 50px;
        height: 3px;
        background: var(--clr-accent-light);
        bottom: 0;
        left: calc(50% - 25px);
    }

    /* Map Container */
    .contact .map-div {
        margin-bottom: 40px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .contact .map-div iframe {
        border-radius: 10px;
    }

    /* Contact Info Section */
    .contact .info {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .contact .info .address,
    .contact .info .email,
    .contact .info .phone {
        display: flex;
        align-items: flex-start;
        margin-bottom: 0;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s ease;
        height: 100%;
    }

    .contact .info .address:hover,
    .contact .info .email:hover,
    .contact .info .phone:hover {
        background: #e9ecef;
        transform: translateY(-2px);
    }

    .contact .info i {
        font-size: 20px;
        color: var(--clr-accent-light);
        width: 44px;
        height: 44px;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        transition: all 0.3s ease;
        margin-right: 15px;
        flex-shrink: 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .contact .info h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
        padding: 0;
    }

    .contact .info p {
        font-size: 16px;
        color: #666;
        margin: 0;
        padding: 0;
        line-height: 1.5;
    }

    /* Contact Form Container */
    .contact-form-container {
        background: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .contact-form-container h3 {
        color: #333;
        font-size: 24px;
        font-weight: 600;
        text-align: center;
        margin-bottom: 30px;
    }

    /* Form Styles - Override any conflicting styles */
    .contact .php-email-form .form-group {
        margin-bottom: 20px;
    }

    .contact .php-email-form label {
        font-weight: 500;
        margin-bottom: 8px;
        color: #333;
        display: block;
        font-size: 14px;
    }

    .contact .php-email-form .form-control {
        background: #fff !important;
        border: 2px solid #eee !important;
        color: #333 !important;
        border-radius: 8px !important;
        padding: 12px 15px !important;
        transition: all 0.3s ease !important;
        font-size: 14px !important;
        width: 100%;
        box-sizing: border-box;
    }

    .contact .php-email-form .form-control:focus {
        border-color: #007bff !important;
        background: #fff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
        outline: none !important;
    }

    .contact .php-email-form .form-control::placeholder {
        color: #999 !important;
        opacity: 1 !important;
    }

    /* Textarea specific styling */
    .contact .php-email-form textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    /* Button Styling */
    .contact .php-email-form .btn-primary {
        background: #007bff;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 16px;
    }

    .contact .php-email-form .btn-primary:hover {
        background: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }

    .contact .php-email-form .btn-primary:disabled {
        background: #6c757d;
        transform: none;
        box-shadow: none;
    }

    /* Error Messages */
    .contact .text-danger {
        color: #dc3545 !important;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }

    /* Form States */
    .contact .php-email-form .loading {
        display: none;
        background: #e3f2fd;
        border: 1px solid #bbdefb;
        color: #1976d2;
        text-align: center;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .contact .php-email-form .sent-message {
        display: none;
        color: #155724;
        background: #d4edda;
        border: 1px solid #c3e6cb;
        text-align: center;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .contact .php-email-form .error-message {
        display: none;
        color: #721c24;
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        text-align: center;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
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
        border-left-color: #28a745;
    }

    .toast-notification.error {
        border-left-color: #dc3545;
    }

    .toast-notification.warning {
        border-left-color: #ffc107;
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
        color: #28a745;
    }

    .toast-notification.error .toast-icon i {
        color: #dc3545;
    }

    .toast-notification.warning .toast-icon i {
        color: #ffc107;
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
        background: #28a745;
    }

    .toast-notification.error .toast-progress::before {
        background: #dc3545;
    }

    .toast-notification.warning .toast-progress::before {
        background: #ffc107;
    }

    @keyframes toast-progress {
        to {
            transform: scaleX(1);
        }
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .contact .info {
            margin-bottom: 30px;
        }

        .contact-form-container {
            margin-bottom: 30px;
        }
    }

    @media (max-width: 768px) {
        .contact .info .address,
        .contact .info .email,
        .contact .info .phone {
            flex-direction: column;
            text-align: center;
            padding: 15px;
            margin-bottom: 15px;
        }

        .contact .info i {
            margin-right: 0;
            margin-bottom: 10px;
        }

        .contact-form-container {
            padding: 20px;
        }

        .contact .section-title h3 {
            font-size: 28px;
        }

        .toast-notification {
            right: 10px;
            left: 10px;
            min-width: auto;
            max-width: none;
        }
    }

    @media (max-width: 576px) {
        .contact {
            padding: 40px 0;
        }

        .contact .container {
            padding: 0 10px;
        }

        .contact-form-container {
            padding: 15px;
        }

        .contact .section-title h3 {
            font-size: 24px;
        }

        .toast-notification {
            top: 10px;
            right: 10px;
            left: 10px;
        }

        .contact .php-email-form .btn-primary {
            width: 100%;
            justify-content: center;
        }
    }

    /* Ensure proper spacing and layout */
    .contact .row {
        margin-left: -15px;
        margin-right: -15px;
    }

    .contact .row > [class*="col-"] {
        padding-left: 15px;
        padding-right: 15px;
    }

    /* Fix any z-index issues */
    .contact {
        position: relative;
        z-index: 1;
    }

    .contact .info,
    .contact-form-container {
        position: relative;
        z-index: 2;
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
        toast.offsetHeight; // Force reflow
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
                                    const input = contactForm.querySelector(`[name="${field}"]`);
                                    if (input) {
                                        let errorElement = input.parentNode.querySelector('.text-danger');
                                        if (!errorElement) {
                                            errorElement = document.createElement('div');
                                            errorElement.className = 'text-danger';
                                            input.parentNode.appendChild(errorElement);
                                        }
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
