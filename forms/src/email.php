<?php

require '../vendor/autoload.php';

function sanitize($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $userEmail = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $passengers = sanitize($_POST['passengers']);
    $arrivalDate = sanitize($_POST['arrivalDate']);
    $departureDate = sanitize($_POST['departureDate']);
    $additionalInfo = sanitize($_POST['additionalInfo']);

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("noreply.aeroparking@gmail.com", "Noreply aeroparking");
    $email->setSubject('Nova rezervacija: ' . $name);
    $email->addTo("rezervacije.aeroparking@gmail.com", "Rezervacije aeroparking");
    $email->addContent(
        "text/html",
        <<<EMAILBODY
            Ime: {$name} <br>
            Email: {$userEmail} <br>
            Telefon: {$phone} <br>
            Datum i vreme dolaska: {$arrivalDate} <br>
            Datum i vreme odlaska: {$departureDate} <br>
            Broj putnika: {$passengers} <br>
            Dodatne napomene: {$additionalInfo}
EMAILBODY
    );
    $sendgrid = new \SendGrid('API_KEY');
    try {
        $response = $sendgrid->send($email);

        if ( $response->statusCode() >= 200 && $response->statusCode() < 300)
        {
            echo json_encode(['status' => 'success', 'message' => 'Reservation email sent']);
        }
        else {
            echo json_encode(['status' => 'error', 'message' => 'exception: ' . $response->body()]);
            http_response_code(500); // Internal Server Error
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'exception: ' . $e->getMessage()]);
        http_response_code(500); // Internal Server Error
    }
}