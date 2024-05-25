
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
const arrival = document.getElementById('arrival-date');
const departure = document.getElementById('departure-date');
const ctaArrival = document.getElementById('cta-arrival-date');
const ctaDeparture = document.getElementById('cta-departure-date');

function syncInputs(event) {
    const newValue = event.target.value;

    if(event.target.name == 'arrival-date') {
        arrival.value = newValue;
        ctaArrival.value = newValue;
    }
    else{
        departure.value = newValue;
        ctaDeparture.value = newValue;
    }

    updatePrice();
}

 function updatePrice() {
    let arrivalDate = arrival.value;
    let departureDate = departure.value;

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

    // do not count arrival day if customer arrived late
    if (arrivalHour >= 22) {
        numOfDays = numOfDays - 1;
    }

    // do not count arrival day if customer left early
    if (departureHour < 2) {
        numOfDays = numOfDays - 1;
    }

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
        return;
    }

    formCharge.textContent = `Cena za ${numOfDays} dana iznosi ${price} dinara.`;
    ctaCharge.textContent = `Cena: ${price} din.`;
}

// ajax call
$(document).ready(function () {
    $("#email-form").submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = {};
        formData["name"] = $("#name").val();
        formData["email"] = $("#email").val();
        formData["passengers"] = $("#passengers").val();
        formData["phone"] = $("#phone").val();
        formData["arrivalDate"] = $("#arrival-date").val();
        formData["departureDate"] = $("#departure-date").val();

        $.ajax({
            type: "POST",
            url: "https://aeroparking.rs/forms/src/email.php",
            data: formData,
            success: function (response) {
                try {
                    let responseObj = JSON.parse(response);
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
                } catch (e) {
                    console.error('Error parsing response:', e);
                    Swal.fire({
                        title: "Greška!",
                        text: "Došlo je do greške na serveru. Molimo kontaktirajte nas drugim putem.",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log('Status:' + status);
                console.log('xhr:' + JSON.stringify(xhr));
                console.log('error:' + JSON.stringify(error));
                Swal.fire({
                        title: "Greška!",
                        text: "Došlo je do greške na serveru. Molimo kontaktirajte nas drugim putem.",
                        icon: "error",
                        confirmButtonText: "OK",
                    }
                );
            },
        });
    });
});