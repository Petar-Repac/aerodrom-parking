
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
const ctaCharge  = document.getElementById('cta-charge');
const today = new Date().toISOString().split('T')[0];

const arrival = document.getElementById('arrival-date');
const departure = document.getElementById('departure-date');


// let calendarNum = (new Date().getDate() > 22)?2: 1;
let calendarNum = 1;
const pickerFrom = new easepick.create({
    element: "#arrival-date",
    css: [
        "assets/vendor/easepick/css/index.css"
    ],
    zIndex: 10,
    format: "DD MMMM YYYY",
    calendars: calendarNum,
    autoApply: false,
    grid: calendarNum,
    LockPlugin: {
        minDate: new Date().toISOString().split("T")[0]
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
        "assets/vendor/easepick/css/index.css"
    ],
    zIndex: 10,
    format: "DD MMMM YYYY",
    calendars: calendarNum,
    autoApply: false,
    grid: calendarNum,
    LockPlugin: {
        minDate: new Date().toISOString().split("T")[0]
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

const cta_pickerFrom = new easepick.create({
    element: "#cta-arrival-date",
    css: [
        "assets/vendor/easepick/css/index.css"
    ],
    zIndex: 10,
    format: "DD MMMM YYYY",
    calendars: calendarNum,
    autoApply: false,
    grid: calendarNum,
    LockPlugin: {
        minDate: new Date().toISOString().split("T")[0]
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
            console.log(e)
            syncInputs(e.detail.date, 'from')
        });
    }
})


const cta_pickerTo = new easepick.create({
    element: "#cta-departure-date",
    css: [
        "assets/vendor/easepick/css/index.css"
    ],
    zIndex: 10,
    format: "DD MMMM YYYY",
    calendars: calendarNum,
    autoApply: false,
    grid: calendarNum,
    LockPlugin: {
        minDate: new Date().toISOString().split("T")[0]
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
arrival.removeAttribute('readonly');


function syncInputs(date, fromOrTo) {

    if(fromOrTo === 'from'){
        pickerFrom.setDate(date);
        cta_pickerFrom.setDate(date);
    }
    else {
        pickerTo.setDate(date);
        cta_pickerTo.setDate(date);
    }
    console.log(pickerFrom.getDate())
    console.log(pickerTo.getDate())
    if(pickerFrom.getDate() && pickerTo.getDate()){
        console.log('updating prices')
        updatePrice()
    }
}

let showReservationForm = true;
function showFormFirstTime() {
    let reservationForm = document.getElementById('reservation-form');

    if(!reservationForm.classList.contains('active') && showReservationForm) {
        reservationForm.classList.toggle('active')
        showReservationForm = false;
    }
}
function updatePrice() {
    let arrivalDate = pickerFrom.getDate();
    let departureDate = pickerTo.getDate();

    if (!arrivalDate || !departureDate) {
        formCharge.textContent = `Cena: - - -`;
        ctaCharge.textContent = `Cena: - - -`;
        return;
    }

    let firstDate = new Date(arrivalDate);
    let secondDate = new Date(departureDate);

    // invalid input
    if (secondDate < firstDate) {
        formCharge.textContent = "Datum dolaska mora biti pre datuma odlaska.";
        ctaCharge.textContent = `Cena: - - -`;
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

    // // do not count arrival day if customer arrived late
    // if (arrivalHour >= 22) {
    //     numOfDays = numOfDays - 1;
    // }
    //
    // // do not count arrival day if customer left early
    // if (departureHour < 2) {
    //     numOfDays = numOfDays - 1;
    // }

    if(numOfDays === 0) {
        formCharge.textContent = `Cena: - - -`;
        ctaCharge.textContent = `Cena: - - -`;
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
        prices.map((item) => {
            if (item.days === numOfDays) {
                price = item.price;
            }
        })
    }

    // correct string output
    if (numOfDays % 10 === 1 && numOfDays !== 11) {
        formCharge.textContent = `Cena za ${numOfDays} dan iznosi ${price} dinara.`;
        ctaCharge.textContent = `Cena: ${price} din.`;
        showFormFirstTime()
        return;
    }

    formCharge.textContent = `Cena za ${numOfDays} dana iznosi ${price} dinara.`;
    ctaCharge.textContent = `Cena: ${price} din.`;
    showFormFirstTime()
}

// ajax call

document.getElementById('email-form').addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData();
    formData.append("name", document.getElementById('name').value);
    formData.append("email", document.getElementById('email').value);
    formData.append("passengers", document.getElementById('passengers').value);
    formData.append("phone", document.getElementById('phone').value);
    formData.append("arrivalDate", document.getElementById('arrival-date').value);
    formData.append("departureDate", document.getElementById('departure-date').value);

    fetch('https://aeroparking.rs/forms/src/email.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(responseObj => {
            console.log('Parsed response:', responseObj);
            if (responseObj.status === "success") {
                Swal.fire({
                    title: "Zahtev za rezervacijom poslat!",
                    text: "Osoblje parkinga će Vas kontaktirati putem telefona ili emaila.",
                    icon: "success",
                    confirmButtonText: "OK",
                });
            } else {
                Swal.fire({
                    title: "Greška!",
                    text: "Došlo je do greške na serveru. Molimo kontaktirajte nas drugim putem.",
                    icon: "error",
                    confirmButtonText: "OK",
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: "Greška!",
                text: "Došlo je do greške na serveru. Molimo kontaktirajte nas drugim putem.",
                icon: "error",
                confirmButtonText: "OK",
            });
        });
});