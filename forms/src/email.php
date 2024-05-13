<?php

require '../vendor/autoload.php';
define('API_KEY', 'AF57-5A8H-OXM1-58LB');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sanitize($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

//&& isset($_POST['apiKey']) && $_POST['apiKey'] === API_KEY
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $passengers = sanitize($_POST['passengers']);
    $arrivalDate = sanitize($_POST['arrivalDate']);
    $departureDate = sanitize($_POST['departureDate']);
    $additionalInfo = sanitize($_POST['additionalInfo']);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 's4.webhostingsrbija.net';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'noreply@aeroparking.rs';    // SMTP username
        $mail->Password = 'noreplyPass123!';                    // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('noreply@aeroparking.rs', 'noreply@aeroparking.rs');
        $mail->addAddress('rezervacije@aeroparking.rs', 'Rezervacije');     // Add a recipient


        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Nova rezervacija: ' . $name;
        $mail->Body    =  <<<EMAILBODY
            Ime: {$name} <br>
            Email: {$email} <br>
            Telefon: {$phone} <br>
            Datum i vreme dolaska: {$arrivalDate} <br>
            Datum i vreme odlaska: {$departureDate} <br>
            Broj putnika: {$passengers} <br>
            Dodatne napomene: {$additionalInfo} 
EMAILBODY;

        //        $mail->AltBody = "Reservation Details:\nName: $name";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Reservation email sent']);
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['status' => 'error', 'message' => 'exception: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid API Key']);
}
