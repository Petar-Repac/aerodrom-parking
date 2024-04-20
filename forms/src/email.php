<?php

require '../vendor/autoload.php';
define('API_KEY', 'AF57-5A8H-OXM1-58LB');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apiKey']) && $_POST['apiKey'] === API_KEY) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $date = sanitize($_POST['date']);
    $time = sanitize($_POST['time']);
    $guests = sanitize($_POST['guests']);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.example.com';                     // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'your-email@example.com';           // SMTP username
        $mail->Password = 'your-password';                    // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('reservations@example.com', 'Reservations');     // Add a recipient
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'New Reservation';
        $mail->Body    = "Reservation Details:<br>Name: $name<br>Date: $date<br>Time: $time<br>Guests: $guests";
        $mail->AltBody = "Reservation Details:\nName: $name\nDate: $date\nTime: $time\nGuests: $guests";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Reservation email sent']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid API Key']);
}
?>