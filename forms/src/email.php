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
    //    $email = sanitize($_POST['email']);
    //    $date = sanitize($_POST['date']);
    //    $time = sanitize($_POST['time']);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 's4.webhostingsrbija.net';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'noreply@aerodromskiparking.rs';    // SMTP username
        $mail->Password = 'noreplyPass123!';                    // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('noreply@aerodromskiparking.rs', 'Mailer');
        $mail->addAddress('rezervacije@aerodromskiparking.rs', 'Reservations');     // Add a recipient
        //        $mail->addReplyTo('info@example.com', 'Information');
        //        $mail->addCC('cc@example.com');
        //        $mail->addBCC('bcc@example.com');

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'New Reservation';
        $mail->Body    = "Reservation Details:<br>Name: $name<br>";
        $mail->AltBody = "Reservation Details:\nName: $name";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Reservation email sent']);
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['status' => 'error', 'message' => 'exception: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid API Key']);
}
