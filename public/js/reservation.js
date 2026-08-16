// flatpickr is loaded as a plain classic <script defer> in
// scripts-homepage.blade.php (before this module's own tag), which
// attaches it to window.flatpickr - its UMD build only ships one
// self-contained file, unlike the ESM build which imports several
// sibling modules (types/options, utils/dom, l10n/default, ...) that
// need to be served individually, so this avoids vendoring that whole
// file tree.
const flatpickr = window.flatpickr;
const confirmDatePlugin = window.confirmDatePlugin;

// Prices are normally injected server-side (see
// resources/views/partials/data/prices.blade.php, backed by the admin-
// editable price table). This hardcoded list is only a last-resort
// fallback if that script tag is ever missing.
const prices = window.PARKING_PRICES || [
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

const extraDayRate = window.PARKING_EXTRA_DAY_RATE || 200;

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

// Format a Date's time-of-day as 24-hour HH:mm, matching the backend's
// date_format:H:i validation. The arrival/departure pickers' TimePlugin
// (format12: false) already picks in 24h, so this just serializes it.
function toTimeString(date) {
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    return `${hours}:${minutes}`;
}

// Check if CTA elements exist
const ctaArrivalElement = document.getElementById('cta-arrival-date');
const ctaDepartureElement = document.getElementById('cta-departure-date');

// Matches easepick's old __lang() helper: resolve the site's chosen
// language (window.translations.lang, from js.php) to a flatpickr
// locale key so month/day names follow the page's language instead of
// always showing English. 'en' needs no locale object - it's
// flatpickr's built-in default. sr/ru are loaded as separate locale
// scripts (see scripts-homepage.blade.php) that register themselves
// onto window.flatpickr.l10ns before this file runs.
function resolvePickerLocale() {
    const lang = window.translations?.lang;
    return (lang === 'sr' || lang === 'ru') ? lang : undefined;
}

// confirmDatePlugin instances hold per-picker state (their own
// confirmContainer element), so each picker needs its own instance -
// sharing one across pickers via the spread pickerOptions below would
// have them all fighting over the same closure.
function makeConfirmPlugin() {
    return new confirmDatePlugin({
        confirmText: window.translations?.datepicker?.apply || 'OK',
        theme: 'dark'
    });
}

// Shared config for all four pickers: a real 24h time picker (hour/minute
// spinner inputs, not <select> dropdowns) bundled with the calendar,
// appended to <body> so it isn't clipped by #reservation-form's
// position:fixed + overflow:hidden sidebar. Without confirmDatePlugin,
// picking date+time only "applies" on blur/outside-click, which reads
// as the picker being stuck open with nothing to confirm - the plugin
// adds a visible confirm button (once a full date+time is picked) that
// closes the picker on click.
const pickerOptions = {
    // By default flatpickr detects Android/iOS and silently swaps in a
    // bare native <input type="datetime-local">, handing off entirely to
    // the OS's own date/time dialog - unstyled (plain white, no visible
    // placeholder), not localized to the page's language, and without
    // the confirm button (confirmDatePlugin explicitly no-ops when
    // fp.isMobile is true). Disabling that keeps our calendar consistent
    // across desktop and mobile.
    disableMobile: true,
    enableTime: true,
    time_24hr: true,
    minuteIncrement: 5,
    dateFormat: "d F Y H:i",
    minDate: "today",
    appendTo: document.body,
    locale: resolvePickerLocale()
};

const pickerFrom = flatpickr("#arrival-date", {
    ...pickerOptions,
    plugins: [makeConfirmPlugin()],
    onChange(selectedDates) {
        if (selectedDates[0]) {
            syncInputs(selectedDates[0], 'from');
        }
    }
});

const pickerTo = flatpickr("#departure-date", {
    ...pickerOptions,
    plugins: [makeConfirmPlugin()],
    onChange(selectedDates) {
        if (selectedDates[0]) {
            syncInputs(selectedDates[0], 'to');
        }
    },
    onClose: expandSidebarIfReady
});

// Only create CTA pickers if the elements exist
let cta_pickerFrom = null;
let cta_pickerTo = null;

if (ctaArrivalElement) {
    cta_pickerFrom = flatpickr(ctaArrivalElement, {
        ...pickerOptions,
        plugins: [makeConfirmPlugin()],
        onChange(selectedDates) {
            if (selectedDates[0]) {
                syncInputs(selectedDates[0], 'from');
            }
        }
    });
}

if (ctaDepartureElement) {
    cta_pickerTo = flatpickr(ctaDepartureElement, {
        ...pickerOptions,
        plugins: [makeConfirmPlugin()],
        onChange(selectedDates) {
            if (selectedDates[0]) {
                syncInputs(selectedDates[0], 'to');
            }
        },
        onClose: expandSidebarIfReady
    });
}

// Keep the main picker and its CTA counterpart showing the same date+time.
// setDate()'s second argument controls whether it fires that picker's own
// onChange - passing false on the *target* being synced means it can't
// cascade back into another syncInputs call and recurse between the two.
function syncInputs(date, fromOrTo) {
    if (fromOrTo === 'from') {
        pickerFrom.setDate(date, false);
        if (cta_pickerFrom) {
            cta_pickerFrom.setDate(date, false);
        }
    } else {
        pickerTo.setDate(date, false);
        if (cta_pickerTo) {
            cta_pickerTo.setDate(date, false);
        }
    }
    if (pickerFrom.selectedDates[0] && pickerTo.selectedDates[0]) {
        updatePrice();
    }
}

// flatpickr keeps its selected date/time in its own internal state,
// separate from the input's raw value - a plain emailForm.reset() clears
// the input but leaves the picker still showing (and holding) the old
// selection, ready to resurface stale dates on the next reservation.
function clearPickers() {
    pickerFrom.clear();
    pickerTo.clear();
    if (cta_pickerFrom) cta_pickerFrom.clear();
    if (cta_pickerTo) cta_pickerTo.clear();
}

let showReservationForm = true;
function showFormFirstTime() {
    let reservationForm = document.getElementById('reservation-form');

    if(reservationForm && !reservationForm.classList.contains('active') && showReservationForm) {
        reservationForm.classList.toggle('active')
        showReservationForm = false;
    }
}

// updatePrice() runs live on every onChange (each calendar click, each
// hour/minute spinner tick), so calling showFormFirstTime() from there
// expanded the sidebar the instant departure got *any* value - before
// the user had actually confirmed it. Only expand once the departure
// picker is actually closed (confirm button, outside click, or Escape)
// with both dates present.
function expandSidebarIfReady(selectedDates) {
    if (pickerFrom.selectedDates[0] && selectedDates[0]) {
        showFormFirstTime();
    }
}


// Helper function to get translation
function __(key) {
    return window.translations[key] || key;
}

function updatePrice() {
    let arrivalDate = pickerFrom.selectedDates[0];
    let departureDate = pickerTo.selectedDates[0];

    if (!arrivalDate || !departureDate) {
        if (formCharge) formCharge.textContent = __('price_label');
        if (ctaCharge) ctaCharge.textContent = __('price_label');
        return;
    }

    let firstDate = new Date(arrivalDate);
    let secondDate = new Date(departureDate);

    // invalid input
    if (secondDate <= firstDate) {
        if (formCharge) formCharge.textContent = __('arrival_before_departure');
        if (ctaCharge) ctaCharge.textContent = __('price_label');
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
        price = numOfDays * extraDayRate;
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
        return;
    }

    if (formCharge) formCharge.textContent = `${__('price_for')} ${numOfDays} ${__('days')} ${__('costs')} ${price} ${__('dinars')}.`;
    if (ctaCharge) ctaCharge.textContent = `${__('price')}: ${price} ${__('din')}.`;
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
    // Always call back to whatever origin this script is actually running
    // on (localhost, demo.aeroparking.rs, aeroparking.rs, ...) instead of
    // a hardcoded domain, which would silently send every request to
    // production regardless of which environment served the page.
    baseUrl: window.location.origin,
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

    if (formData.arrivalDate && formData.departureDate && formData.arrivalTime && formData.departureTime) {
        const arrivalDateTime = new Date(`${formData.arrivalDate}T${formData.arrivalTime}`);
        const departureDateTime = new Date(`${formData.departureDate}T${formData.departureTime}`);

        if (departureDateTime <= arrivalDateTime) {
            errors.push(__('arrival_before_departure'));
        }
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
        const arrivalDate = pickerFrom.selectedDates[0];
        const departureDate = pickerTo.selectedDates[0];

        // Get form data
        const formData = {
            name: document.getElementById('name')?.value?.trim() || '',
            email: document.getElementById('email')?.value?.trim() || '',
            passengers: document.getElementById('passengers')?.value || '',
            phone: document.getElementById('phone')?.value?.trim() || '',
            arrivalDate: arrivalDate ? toLocalDateString(new Date(arrivalDate)) : '',
            departureDate: departureDate ? toLocalDateString(new Date(departureDate)) : '',
            arrivalTime: arrivalDate ? toTimeString(new Date(arrivalDate)) : '',
            departureTime: departureDate ? toTimeString(new Date(departureDate)) : '',
            additionalInfo: document.getElementById('additional-info')?.value?.trim() || '',
            // /api/reservations runs under the 'api' middleware group, which
            // doesn't resolve locale from the URL like page routes do - the
            // backend needs this to send the confirmation email in the
            // customer's actual language instead of always falling back to
            // the app default.
            locale: window.translations?.lang || 'sr'
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
                        clearPickers();
                        const reservationForm = document.getElementById('reservation-form');
                        if (reservationForm) {
                            reservationForm.classList.remove('active');
                        }
                        showReservationForm = true;
                    });
                } else {
                    alert(`${__('reservation_sent_title')} ${__('reservation_sent_message')}`);
                    emailForm.reset();
                    clearPickers();
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
