import easepick from '../vendor/easepick/js/main.js'

const prices = [
    { days: 1, price: 500 },
    { days: 2, price: 900 },
    { days: 3, price: 1300 },
    { days: 4, price: 1700 },
    { days: 5, price: 2100 },
    { days: 6, price: 2500 },
    { days: 7, price: 2900 },

    { days: 8, price: 3300 },
    { days: 9, price: 3700 },
    { days: 10, price: 4100 },
    { days: 11, price: 4500 },
    { days: 12, price: 4900 },
    { days: 13, price: 5100 },
    { days: 14, price: 5300 },

    { days: 15, price: 5500 },
    { days: 16, price: 5700 },
    { days: 17, price: 5800 },
    { days: 18, price: 5900 },
    { days: 19, price: 6000 },
    { days: 20, price: 6100 },
    { days: 21, price: 6200 },

    { days: 22, price: 6300 },
    { days: 23, price: 6400 },
    { days: 24, price: 6500 },
    { days: 25, price: 6600 },
    { days: 26, price: 6700 },
    { days: 27, price: 6800 },
    { days: 28, price: 6900 },

    { days: 29, price: 7000 },
    { days: 30, price: 7100 },
    { days: 31, price: 7200 },
    { days: 32, price: 7300 },
    { days: 33, price: 7400 },
    { days: 34, price: 7500 },
    { days: 35, price: 7600 },

    { days: 36, price: 7700 },
    { days: 37, price: 7800 },
    { days: 38, price: 7900 },
    { days: 39, price: 8000 },
    { days: 40, price: 8100 }
];

const formCharge = document.getElementById('form-charge');
const ctaCharge = document.getElementById('cta-charge');

// Format a Date as YYYY-MM-DD using its local calendar date, not UTC.
// toISOString() converts to UTC first, which shifts the date backward
// a day for any timezone ahead of UTC - that shift was causing "today"
// to be rejected as an arrival date no matter what was picked.
function toLocalDateString(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

const today = toLocalDateString(new Date());

const arrival = document.getElementById('arrival-date');
const departure = document.getElementById('departure-date');

// Check if CTA elements exist
const ctaArrivalElement = document.getElementById('cta-arrival-date');
const ctaDepartureElement = document.getElementById('cta-departure-date');

// let calendarNum = (new Date().getDate() > 22)?2: 1;
let calendarNum = 1;
const pickerFrom = new easepick.create({
    element: "#arrival-date",
    css: [
        "vendor/easepick/css/index.css"
    ],
    zIndex: 10,
    format: "DD MMMM YYYY",
    calendars: calendarNum,
    autoApply: false,
    grid: calendarNum,
    positionOverride:"center",
    LockPlugin: {
        minDate: today
    },
    plugins: [
        "AmpPlugin",
        "LockPlugin"
    ],
    AmpPlugin: {
        resetButton: true
    },

    setup(picker) {
        picker.on('select', (e) => {
            syncInputs(e.detail.date, 'from')
        });
    }
})

const pickerTo = new easepick.create({
    element: "#departure-date",
    css: [
        "vendor/easepick/css/index.css"
    ],
    zIndex: 10,
    format: "DD MMMM YYYY",
    calendars: calendarNum,
    autoApply: false,
    grid: calendarNum,
    positionOverride:"center",

    LockPlugin: {
        minDate: today
    },
    plugins: [
        "AmpPlugin",
        "LockPlugin"
    ],
    AmpPlugin: {
        resetButton: true
    },
    setup(picker) {
        picker.on('select', (e) => {
            syncInputs(e.detail.date, 'to')
        });
    }
})

// Only create CTA pickers if the elements exist
let cta_pickerFrom = null;
let cta_pickerTo = null;

if (ctaArrivalElement) {
    cta_pickerFrom = new easepick.create({
        element: "#cta-arrival-date",
        css: [
            "vendor/easepick/css/index.css"
        ],
        zIndex: 10,
        format: "DD MMMM YYYY",
        calendars: calendarNum,
        autoApply: false,
        grid: calendarNum,
        LockPlugin: {
            minDate: today
        },
        required: true,
        plugins: [
            "AmpPlugin",
            "LockPlugin"
        ],
        AmpPlugin: {
            resetButton: true
        },
        setup(picker) {
            picker.on('select', (e) => {
                syncInputs(e.detail.date, 'from')
            });
        }
    })
}

if (ctaDepartureElement) {
    cta_pickerTo = new easepick.create({
        element: "#cta-departure-date",
        css: [
            "vendor/easepick/css/index.css"
        ],
        zIndex: 10,
        format: "DD MMMM YYYY",
        calendars: calendarNum,
        autoApply: false,
        grid: calendarNum,
        LockPlugin: {
            minDate: today
        },
        required: true,
        plugins: [
            "AmpPlugin",
            "LockPlugin"
        ],
        AmpPlugin: {
            resetButton: true
        },
        setup(picker) {
            picker.on('select', (e) => {
                syncInputs(e.detail.date, 'to')
            });
        }
    })
}

if (arrival) {
    arrival.removeAttribute('readonly');
}

function syncInputs(date, fromOrTo) {
    if(fromOrTo === 'from'){
        pickerFrom.setDate(date);
        // Only sync CTA picker if it exists
        if (cta_pickerFrom) {
            cta_pickerFrom.setDate(date);
        }
    }
    else {
        pickerTo.setDate(date);
        // Only sync CTA picker if it exists
        if (cta_pickerTo) {
            cta_pickerTo.setDate(date);
        }
    }
    if(pickerFrom.getDate() && pickerTo.getDate()){
        updatePrice()
    }
}

let showReservationForm = true;
function showFormFirstTime() {
    let reservationForm = document.getElementById('reservation-form');

    if(reservationForm && !reservationForm.classList.contains('active') && showReservationForm) {
        reservationForm.classList.toggle('active')
        showReservationForm = false;
    }
}


// Helper function to get translation
function __(key) {
    return window.translations[key] || key;
}

function updatePrice() {
    let arrivalDate = pickerFrom.getDate();
    let departureDate = pickerTo.getDate();

    if (!arrivalDate || !departureDate) {
        if (formCharge) formCharge.textContent = __('price_label');
        if (ctaCharge) ctaCharge.textContent = __('price_label');
        return;
    }

    let firstDate = new Date(arrivalDate);
    let secondDate = new Date(departureDate);

    // invalid input
    if (secondDate < firstDate) {
        if (formCharge) formCharge.textContent = __('arrival_before_departure');
        if (ctaCharge) ctaCharge.textContent = __('price_label');
        showFormFirstTime()
        return;
    }

    // Set both dates to midnight
    let start = new Date(firstDate.getFullYear(), firstDate.getMonth(), firstDate.getDate());
    let end = new Date(secondDate.getFullYear(), secondDate.getMonth(), secondDate.getDate());

    // Calculate the difference in milliseconds
    let diff = end - start;

    // Convert milliseconds to days and add 1 to count both start and end dates
    let numOfDays = Math.round(diff / (1000 * 60 * 60 * 24)) + 1;

    //  arrival after 22h and departure before 2AM
    let arrivalHour = firstDate.getHours();
    let departureHour = secondDate.getHours();

    if(numOfDays === 0) {
        if (formCharge) formCharge.textContent = `Cena: - - -`;
        if (ctaCharge) ctaCharge.textContent = `Cena: - - -`;
        return;
    }

    let price;

    // more than 40 days
    if (numOfDays > 40 ) {
        price = numOfDays * 200;
    }
    else {
        // check for price in prices array
        // AKA price lookup
        prices.forEach((item) => {
            if (item.days === numOfDays) {
                price = item.price;
            }
        })
    }

    // correct string output
    if (numOfDays % 10 === 1 && numOfDays !== 11) {
        if (formCharge) formCharge.textContent = `${__('price_for')} ${numOfDays} ${__('day')} ${__('costs')} ${price} ${__('dinars')}.`;
        if (ctaCharge) ctaCharge.textContent = `${__('price')}: ${price} ${__('din')}.`;
        showFormFirstTime()
        return;
    }

    if (formCharge) formCharge.textContent = `${__('price_for')} ${numOfDays} ${__('days')} ${__('costs')} ${price} ${__('dinars')}.`;
    if (ctaCharge) ctaCharge.textContent = `${__('price')}: ${price} ${__('din')}.`;
    showFormFirstTime()
}

// Pricing table click functionality - SIMPLIFIED
console.log('DOM loaded, setting up pricing table...');

const pricingCells = document.querySelectorAll('.pricing .pricing-cell:not(.info-cell)');
console.log('Found pricing cells:', pricingCells.length);

pricingCells.forEach(cell => {
    cell.addEventListener('click', function() {
        console.log('Pricing cell clicked - opening form');

        // Remove selected class from all cells
        pricingCells.forEach(c => c.classList.remove('selected'));

        // Add selected class to clicked cell
        this.classList.add('selected');

        // Simply show the reservation form without any date/price updates
        const reservationForm = document.getElementById('reservation-form');
        if (reservationForm) {
            console.log('Found reservation form, making it active');
            reservationForm.classList.toggle('active')
        } else {
            console.log('Reservation form not found');
        }
    });
});

// Add keyboard navigation
pricingCells.forEach(cell => {
    cell.setAttribute('tabindex', '0');
    cell.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            this.click();
        }
    });
});

// Configuration for API endpoint
const API_CONFIG = {
    // Change this to your Laravel app URL
    baseUrl: 'https://aeroparking.rs', // or your Laravel app domain
    endpoints: {
        reservations: '/api/reservations'
    }
};

// Helper function to show loading state with translations
function setFormLoading(isLoading) {
    const submitButton = document.querySelector('#email-form button[type="submit"]');
    if (submitButton) {
        if (isLoading) {
            submitButton.disabled = true;
            submitButton.textContent = __('sending');
        } else {
            submitButton.disabled = false;
            submitButton.textContent = __('send_request');
        }
    }
}

// Helper function to validate form data with translations
function validateFormData(formData) {
    const errors = [];

    if (!formData.name || formData.name.trim().length < 2) {
        errors.push(__('name_min_length'));
    }

    if (!formData.email || !formData.email.includes('@')) {
        errors.push(__('valid_email'));
    }

    if (!formData.phone || formData.phone.trim().length < 6) {
        errors.push(__('valid_phone'));
    }

    if (!formData.passengers || parseInt(formData.passengers) < 1) {
        errors.push(__('passengers_min'));
    }

    if (!formData.arrivalDate) {
        errors.push(__('enter_arrival_date'));
    }

    if (!formData.departureDate) {
        errors.push(__('enter_departure_date'));
    }

    return errors;
}

// Ajax call for form submission - Updated for Laravel API
const emailForm = document.getElementById('email-form');
if (emailForm) {
    emailForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Get dates from the pickers in YYYY-MM-DD format (local calendar
        // date, not the localized "DD MMMM YYYY" display text and not
        // toISOString(), which would shift the date back a day in
        // timezones ahead of UTC)
        const arrivalDate = pickerFrom.getDate();
        const departureDate = pickerTo.getDate();

        // Get form data
        const formData = {
            name: document.getElementById('name')?.value?.trim() || '',
            email: document.getElementById('email')?.value?.trim() || '',
            passengers: document.getElementById('passengers')?.value || '',
            phone: document.getElementById('phone')?.value?.trim() || '',
            arrivalDate: arrivalDate ? toLocalDateString(new Date(arrivalDate)) : '',
            departureDate: departureDate ? toLocalDateString(new Date(departureDate)) : '',
            additionalInfo: document.getElementById('additional-info')?.value?.trim() || ''
        };

        // Validate form data
        const validationErrors = validateFormData(formData);
        if (validationErrors.length > 0) {
            const errorMessage = validationErrors.join('\n');
            if (typeof Sweetalert2 !== 'undefined') {
                Sweetalert2.fire({
                    title: __('data_error'),
                    text: errorMessage,
                    icon: "warning",
                    confirmButtonText: __('ok'),
                });
            } else {
                alert(`${__('data_error')}:\n${errorMessage}`);
            }
            return;
        }

        // Show loading state
        setFormLoading(true);

        try {
            // Send request to Laravel API
            const response = await fetch(`${API_CONFIG.baseUrl}${API_CONFIG.endpoints.reservations}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    // Add CSRF token if needed (for web routes)
                    // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify(formData)
            });

            const responseData = await response.json();

            // Success message
            if (response.ok && responseData.status === "success") {
                // Google Ads conversion tracking
                if (typeof gtag === 'function') {
                    gtag('event', 'conversion', {'send_to': 'AW-16537161463/5x0ICLGct6kZEPedxM09'});
                }

                if (typeof Sweetalert2 !== 'undefined') {
                    Sweetalert2.fire({
                        title: __('reservation_sent_title'),
                        text: __('reservation_sent_message'),
                        icon: "success",
                        confirmButtonText: __('ok'),
                    }).then(() => {
                        emailForm.reset();
                        const reservationForm = document.getElementById('reservation-form');
                        if (reservationForm) {
                            reservationForm.classList.remove('active');
                        }
                        showReservationForm = true;
                    });
                } else {
                    alert(`${__('reservation_sent_title')} ${__('reservation_sent_message')}`);
                    emailForm.reset();
                }
            }
            else {
                // Error handling
                let errorMessage = __('server_error');

                if (responseData.errors) {
                    // Laravel validation errors
                    const errors = Object.values(responseData.errors).flat();
                    errorMessage = errors.join('\n');
                } else if (responseData.message) {
                    errorMessage = responseData.message;
                }

                if (typeof Sweetalert2 !== 'undefined') {
                    Sweetalert2.fire({
                        title:  __('error'),
                        text: errorMessage,
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                } else {
                    alert(`${__('error')},: ${errorMessage}`);
                }
            }
        }
        catch (error) {
            console.error('Form submission error:', error);

            let errorMessage = __('submission_error');

            // Check if it's a network error
            if (!navigator.onLine) {
                errorMessage = __('check_connection');
            } else if (error.name === 'TypeError') {
                errorMessage = __('server_communication_error');
            }

            if (typeof Sweetalert2 !== 'undefined') {
                Sweetalert2.fire({
                    title: __('error'),
                    text: errorMessage,
                    icon: "error",
                    confirmButtonText: __('ok'),
                });
            } else {
                alert(`${__('error')}: ${errorMessage}`);
            }
        } finally {
            // Remove loading state
            setFormLoading(false);
        }
    });
}
