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

// The parking is a physical service in Serbia, so "today" always means
// today in Serbia - not the visitor's own device timezone. Without this,
// a customer browsing from another timezone near their local midnight
// could see the wrong minimum bookable date relative to Belgrade's actual
// calendar day.
function belgradeTodayString() {
    return new Intl.DateTimeFormat('en-CA', { timeZone: 'Europe/Belgrade' }).format(new Date());
}

function belgradeTodayDate() {
    const [year, month, day] = belgradeTodayString().split('-').map(Number);
    return new Date(year, month - 1, day);
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
// have them all fighting over the same closure. showAlways is required
// here: the plugin's default onChange only reveals the button when
// fp.config.enableTime/mode==="multiple"/monthSelect is set (see
// confirmDate.js), none of which apply now that dates and times are
// separate single-date pickers - without it the button would never
// appear at all.
function makeConfirmPlugin() {
    return new confirmDatePlugin({
        confirmText: window.translations?.datepicker?.apply || 'OK',
        theme: 'dark',
        showAlways: true
    });
}

// Shared config for the date-only pickers (sidebar arrival/departure date
// inputs and both CTA inputs), appended to <body> so it isn't clipped by
// #reservation-form's position:fixed + overflow:hidden sidebar. Without
// confirmDatePlugin, picking a date only "applies" on blur/outside-click,
// which reads as the picker being stuck open with nothing to confirm - the
// plugin adds a visible confirm button that closes the picker on click.
const dateOnlyOptions = {
    // By default flatpickr detects Android/iOS and silently swaps in a
    // bare native <input type="date">, handing off entirely to the OS's
    // own date dialog - unstyled (plain white, no visible placeholder),
    // not localized to the page's language, and without the confirm
    // button (confirmDatePlugin explicitly no-ops when fp.isMobile is
    // true). Disabling that keeps our calendar consistent across desktop
    // and mobile.
    disableMobile: true,
    // A single-date (non enableTime) flatpickr closes itself the instant a
    // day is clicked (closeOnSelect defaults to true), which never gave
    // the confirm button a chance to be seen or clicked. Keeping it open
    // until the confirm button is clicked matches the time pickers' flow.
    closeOnSelect: false,
    dateFormat: "d F Y",
    // A plain "today" string resolves against the visitor's own device
    // clock/timezone - using Belgrade's calendar date instead keeps the
    // minimum bookable date correct for a customer browsing from abroad
    // (see belgradeTodayDate() above).
    minDate: belgradeTodayDate(),
    appendTo: document.body,
    locale: resolvePickerLocale()
};

const pickerFrom = flatpickr("#arrival-date", {
    ...dateOnlyOptions,
    plugins: [makeConfirmPlugin()],
    onChange(selectedDates) {
        if (selectedDates[0]) {
            syncInputs(selectedDates[0], 'from');
        }
    }
});

const pickerTo = flatpickr("#departure-date", {
    ...dateOnlyOptions,
    plugins: [makeConfirmPlugin()],
    onChange(selectedDates) {
        if (selectedDates[0]) {
            syncInputs(selectedDates[0], 'to');
        }
    },
    onClose: expandSidebarIfReady
});

// Arrival/departure time are plain native <select> elements (see
// reservation-drawer.blade.php) rather than flatpickr instances - a
// flatpickr time-only picker kept auto-selecting its own hour input's
// text on every open regardless of any guard added against it, which is
// exactly the mobile text-selection callout this was meant to avoid. A
// native select can't hold an invalid value and has no text to select in
// the first place.
const timeFromSelect = document.getElementById('arrival-time');
const timeToSelect = document.getElementById('departure-time');

// Current Belgrade wall-clock time - the parking is a physical service in
// Serbia, so "now" means Belgrade's clock, not the visitor's own device
// timezone (mirrors belgradeTodayString() above). hourCycle: 'h23' pins
// midnight to "00" - some engines report "24" for hour:'2-digit' with
// hour12:false depending on locale, which would break the minutes math.
function getBelgradeNowParts() {
    const parts = new Intl.DateTimeFormat('en-GB', {
        timeZone: 'Europe/Belgrade',
        hour: '2-digit',
        minute: '2-digit',
        hourCycle: 'h23'
    }).formatToParts(new Date());

    return {
        hour: Number(parts.find(p => p.type === 'hour').value),
        minute: Number(parts.find(p => p.type === 'minute').value)
    };
}

function getBelgradeNowMinutes() {
    const { hour, minute } = getBelgradeNowParts();
    return hour * 60 + minute;
}

// "HH:MM" for the next bookable half-hour slot (current time rounded up),
// or null once it's past 23:30 - there is no later slot left today.
function getRoundedUpTimeString() {
    const roundedMinutes = Math.ceil(getBelgradeNowMinutes() / 30) * 30;
    if (roundedMinutes >= 24 * 60) return null;

    const hour = Math.floor(roundedMinutes / 60);
    const minute = roundedMinutes % 60;
    return `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
}

// Defaults both time selects to "now" rounded up to the next half hour
// instead of leaving the disabled placeholder selected - most bookings are
// same-day, so this saves scrolling through the list in the common case
// while leaving every option still free to change.
function applyDefaultTimeSelections() {
    const roundedNow = getRoundedUpTimeString();
    if (!roundedNow) return;

    if (timeFromSelect) timeFromSelect.value = roundedNow;
    if (timeToSelect) timeToSelect.value = roundedNow;
}
applyDefaultTimeSelections();

// When the arrival date is today (Belgrade calendar day), hide/disable any
// arrival-time option that has already passed - no point offering a 09:00
// arrival if it's currently 14:00. Any other arrival date leaves the full
// list available again (this recomputes from scratch every call, so
// switching back off "today" un-hides everything). Re-picks a valid
// default if the previously-selected time is the one that just got hidden.
function updateArrivalTimeOptions(arrivalDate) {
    if (!timeFromSelect) return;

    const isToday = !!arrivalDate && toLocalDateString(new Date(arrivalDate)) === belgradeTodayString();
    const nowMinutes = isToday ? getBelgradeNowMinutes() : null;
    const previousValue = timeFromSelect.value;
    let previousValueStillValid = false;

    Array.from(timeFromSelect.options).forEach(function (option) {
        if (!option.value) return; // the disabled placeholder

        const [h, m] = option.value.split(':').map(Number);
        const isPast = isToday && (h * 60 + m) < nowMinutes;

        // hidden removes it from the dropdown list itself; disabled is a
        // fallback so it can't be selected even where hidden on <option>
        // isn't honored.
        option.hidden = isPast;
        option.disabled = isPast;

        if (option.value === previousValue && !isPast) {
            previousValueStillValid = true;
        }
    });

    if (!previousValueStillValid) {
        timeFromSelect.value = (isToday ? getRoundedUpTimeString() : null) || '';
    }
}

// Only create CTA pickers if the elements exist. CTA is date-only - it's
// a landing-page teaser that feeds the sidebar's arrival/departure date
// fields, not a full booking form, so it never collects time.
let cta_pickerFrom = null;
let cta_pickerTo = null;

if (ctaArrivalElement) {
    cta_pickerFrom = flatpickr(ctaArrivalElement, {
        ...dateOnlyOptions,
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
        ...dateOnlyOptions,
        plugins: [makeConfirmPlugin()],
        onChange(selectedDates) {
            if (selectedDates[0]) {
                syncInputs(selectedDates[0], 'to');
            }
        },
        onClose: expandSidebarIfReady
    });
}

// Prevent the departure date picker from allowing (or keeping) a date
// before the currently-selected arrival date. Mirrors the equivalent
// LockPlugin behaviour from the previous easepick-based picker.
function lockDepartureMinDate(picker, arrivalDate) {
    if (!picker) return;

    const minDate = arrivalDate ? new Date(arrivalDate) : belgradeTodayDate();
    picker.set('minDate', minDate);

    // If a departure date is already selected and is now before the new
    // arrival date, clear it so the user has to re-pick a valid date.
    const selectedDeparture = picker.selectedDates[0];
    if (selectedDeparture && arrivalDate && new Date(selectedDeparture) < new Date(arrivalDate)) {
        picker.clear();
    }
}

// flatpickr only recalculates a popup's position on open and on window
// resize (see the vendored flatpickr.min.js - no scroll listener at all),
// which normally goes unnoticed because a plain page scroll moves an
// absolutely-positioned popup along with the rest of the document. That
// breaks down for #reservation-form: it's `position: fixed` with its own
// `overflow-y: auto` (see style.css), so scrolling *inside* the sidebar -
// desktop mouse wheel, or a mobile swipe, since disableMobile keeps this
// custom picker on phones too - moves the input within the viewport
// without moving window scroll at all, leaving the popup (appended to
// <body>, positioned once at open) behind. Recomputing on every scroll
// keeps it glued to whichever input opened it; capture:true is needed
// because native scroll events don't bubble, so a plain window listener
// would only ever see window's own scroll, not the sidebar's.
const allPickers = [pickerFrom, pickerTo, cta_pickerFrom, cta_pickerTo].filter(Boolean);
let openPicker = null;

allPickers.forEach(function (fp) {
    fp.config.onOpen.push(function () { openPicker = fp; });
    fp.config.onClose.push(function () { if (openPicker === fp) openPicker = null; });
});

let repositionQueued = false;
function repositionOpenPicker() {
    if (!openPicker || repositionQueued) return;
    repositionQueued = true;
    requestAnimationFrame(function () {
        repositionQueued = false;
        if (openPicker && openPicker.isOpen) {
            openPicker._positionCalendar();
        }
    });
}
window.addEventListener('scroll', repositionOpenPicker, { capture: true, passive: true });

// Keep the sidebar date picker and its CTA counterpart showing the same
// date, and keep the departure picker's minimum date locked to whatever
// arrival date was just picked. setDate()'s second argument controls
// whether it fires that picker's own onChange - passing false on the
// *target* being synced means it can't cascade back into another
// syncInputs call and recurse between the two.
function syncInputs(date, fromOrTo) {
    if (fromOrTo === 'from') {
        pickerFrom.setDate(date, false);
        if (cta_pickerFrom) {
            cta_pickerFrom.setDate(date, false);
        }

        lockDepartureMinDate(pickerTo, date);
        lockDepartureMinDate(cta_pickerTo, date);
        updateArrivalTimeOptions(date);
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

// flatpickr keeps its selected date in its own internal state, separate
// from the input's raw value - a plain emailForm.reset() clears the
// input but leaves the picker still showing (and holding) the old
// selection, ready to resurface stale dates on the next reservation.
function clearPickers() {
    pickerFrom.clear();
    pickerTo.clear();
    if (cta_pickerFrom) cta_pickerFrom.clear();
    if (cta_pickerTo) cta_pickerTo.clear();
    updateArrivalTimeOptions(null);
    applyDefaultTimeSelections();
}

let showReservationForm = true;
function showFormFirstTime() {
    let reservationForm = document.getElementById('reservation-form');

    if(reservationForm && !reservationForm.classList.contains('active') && showReservationForm) {
        reservationForm.classList.toggle('active')
        showReservationForm = false;
    }
}

// updatePrice() runs live on every onChange (each calendar click), so
// calling showFormFirstTime() from there expanded the sidebar the instant
// departure got *any* value - before the user had actually confirmed it.
// Only expand once the departure picker is actually closed (confirm
// button, outside click, or Escape) with both dates present.
function expandSidebarIfReady(selectedDates) {
    if (pickerFrom.selectedDates[0] && selectedDates[0]) {
        showFormFirstTime();
    }
}

// Helper function to get translation
function __(key) {
    return window.translations[key] || key;
}

// Store current price globally - needed by handleReservationSubmit below,
// since the payment buttons submit the numeric total alongside the form.
let currentPrice = 0;

function updatePrice() {
    let arrivalDate = pickerFrom.selectedDates[0];
    let departureDate = pickerTo.selectedDates[0];

    if (!arrivalDate || !departureDate) {
        if (formCharge) formCharge.textContent = __('price_label');
        if (ctaCharge) ctaCharge.textContent = __('price_label');
        currentPrice = 0;
        return;
    }

    let firstDate = new Date(arrivalDate);
    let secondDate = new Date(departureDate);

    // invalid input
    if (secondDate <= firstDate) {
        if (formCharge) formCharge.textContent = __('arrival_before_departure');
        if (ctaCharge) ctaCharge.textContent = __('price_label');
        currentPrice = 0;
        return;
    }

    // Set both dates to midnight
    let start = new Date(firstDate.getFullYear(), firstDate.getMonth(), firstDate.getDate());
    let end = new Date(secondDate.getFullYear(), secondDate.getMonth(), secondDate.getDate());

    // Calculate the difference in milliseconds
    let diff = end - start;

    // Convert milliseconds to days and add 1 to count both start and end dates
    let numOfDays = Math.round(diff / (1000 * 60 * 60 * 24)) + 1;

    if(numOfDays === 0) {
        if (formCharge) formCharge.textContent = `Cena: - - -`;
        if (ctaCharge) ctaCharge.textContent = `Cena: - - -`;
        currentPrice = 0;
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

    // Store current price
    currentPrice = price;

    // Format price as decimal with RSD currency (e.g. 7.700,00 RSD)
    var priceFormatted = new Intl.NumberFormat('sr-RS', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(price) + ' RSD';

    // correct string output
    if (numOfDays % 10 === 1 && numOfDays !== 11) {
        if (formCharge) formCharge.textContent = `${__('price_for')} ${numOfDays} ${__('day')} ${__('costs')} ${priceFormatted}.`;
        if (ctaCharge) ctaCharge.textContent = `${__('price')}: ${priceFormatted}.`;
        return;
    }

    if (formCharge) formCharge.textContent = `${__('price_for')} ${numOfDays} ${__('days')} ${__('costs')} ${priceFormatted}.`;
    if (ctaCharge) ctaCharge.textContent = `${__('price')}: ${priceFormatted}.`;
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
        reservations: '/api/reservations'  // Uses PaymentController for both payment methods
    }
};

// Helper function to show loading state with translations
function setFormLoading(isLoading, buttonElement) {
    if (buttonElement) {
        if (isLoading) {
            buttonElement.disabled = true;
            buttonElement.dataset.originalText = buttonElement.textContent;
            buttonElement.innerHTML = '<i class="bi bi-hourglass-split"></i> ' + __('sending');
        } else {
            buttonElement.disabled = false;
            buttonElement.innerHTML = buttonElement.dataset.originalText || __('send_request');
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

    if (!formData.arrivalTime) {
        errors.push(__('enter_arrival_time'));
    }

    if (!formData.departureTime) {
        errors.push(__('enter_departure_time'));
    }

    if (formData.arrivalDate && formData.departureDate && formData.arrivalTime && formData.departureTime) {
        const arrivalDateTime = new Date(`${formData.arrivalDate}T${formData.arrivalTime}`);
        const departureDateTime = new Date(`${formData.departureDate}T${formData.departureTime}`);

        if (arrivalDateTime < new Date()) {
            errors.push(__('arrival_in_past'));
        } else if (departureDateTime <= arrivalDateTime) {
            errors.push(__('arrival_before_departure'));
        }
    }

    if (!formData.totalPrice || formData.totalPrice <= 0) {
        errors.push(__('invalid_price'));
    }

    return errors;
}

// Handle form submission with payment method. submitterButton is the
// specific payment button that was clicked (passed in explicitly from the
// submit listener below, rather than read off the global `event` - the
// global isn't reliably populated across browsers once execution is
// inside an async function called from the handler).
async function handleReservationSubmit(paymentMethod, submitterButton) {
    // Dates are serialized as YYYY-MM-DD from local calendar values (not
    // the localized "d F Y" display text and not toISOString(), which
    // would shift the date back a day in timezones ahead of UTC). Times
    // come straight from the select elements' values, already in HH:mm.
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
        arrivalTime: timeFromSelect?.value || '',
        departureTime: timeToSelect?.value || '',
        additionalInfo: document.getElementById('additional-info')?.value?.trim() || '',
        paymentMethod: paymentMethod,
        totalPrice: currentPrice,
        // /api/reservations runs under the 'api' middleware group, which
        // doesn't resolve locale from the URL like page routes do - the
        // backend needs this to send the confirmation/notification emails
        // in the customer's actual language instead of always falling
        // back to the app default.
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
        return false;
    }

    // Show loading state
    setFormLoading(true, submitterButton);

    try {
        // Send request to Laravel API
        const response = await fetch(`${API_CONFIG.baseUrl}${API_CONFIG.endpoints.reservations}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(formData)
        });

        const responseData = await response.json();

        // Success handling
        if (response.ok && responseData.status === "success") {
            // Google Ads conversion tracking
            if (typeof gtag === 'function') {
                gtag('event', 'conversion', {'send_to': 'AW-16537161463/5x0ICLGct6kZEPedxM09'});
            }
            if (responseData.payment_method === 'online' && responseData.payment_url) {
                // Redirect to payment page
                window.location.href = responseData.payment_url;
            } else {
                // Show success message for on-site payment
                if (typeof Sweetalert2 !== 'undefined') {
                    Sweetalert2.fire({
                        title: __('reservation_sent_title'),
                        text: __('reservation_sent_message'),
                        icon: "success",
                        confirmButtonText: __('ok'),
                    }).then(() => {
                        document.getElementById('email-form').reset();
                        clearPickers();
                        const reservationForm = document.getElementById('reservation-form');
                        if (reservationForm) {
                            reservationForm.classList.remove('active');
                        }
                        showReservationForm = true;
                        currentPrice = 0;
                    });
                } else {
                    alert(`${__('reservation_sent_title')} ${__('reservation_sent_message')}`);
                    document.getElementById('email-form').reset();
                    clearPickers();
                }
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
                alert(`${__('error')}: ${errorMessage}`);
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
        setFormLoading(false, submitterButton);
    }
}

// Set up form submission handlers
const emailForm = document.getElementById('email-form');
if (emailForm) {
    emailForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Determine which button was clicked
        const paymentMethod = e.submitter?.dataset?.paymentMethod || 'payment-onsite';

        await handleReservationSubmit(paymentMethod, e.submitter);
    });
}
