<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Default timeout in seconds
     */
    protected int $timeout = 20;

    /**
     * Send an email using PHPMailer with timeout
     *
     * @param string $to Recipient email address
     * @param string $subject Email subject
     * @param string $content Email content (HTML)
     * @param string $toName Recipient name
     * @return bool
     */
    public function sendEmail($to, $subject, $content, $toName = '')
    {
        return $this->sendEmailWithAttachments($to, $subject, $content, $toName, []);
    }

    /**
     * Send an email with attachments using PHPMailer with timeout
     *
     * @param string $to Recipient email address
     * @param string $subject Email subject
     * @param string $content Email content (HTML)
     * @param string $toName Recipient name
     * @param array $attachments Array of attachments: [['content' => string, 'filename' => string, 'type' => string]]
     * @return bool
     */
    public function sendEmailWithAttachments($to, $subject, $content, $toName = '', array $attachments = [])
    {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = config('mail.mailers.smtp.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.mailers.smtp.username');
            $mail->Password = config('mail.mailers.smtp.password');
            $mail->SMTPSecure = config('mail.mailers.smtp.encryption');
            $mail->Port = config('mail.mailers.smtp.port');

            // Set timeout for SMTP connection
            $mail->Timeout = $this->timeout;

            // Set timeout for reading server response
            $mail->SMTPKeepAlive = false;

            // Recipients
            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress($to, $toName);

            // Set charset to UTF-8
            $mail->CharSet = 'UTF-8';

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $content;

            // Add attachments
            foreach ($attachments as $attachment) {
                if (isset($attachment['content']) && isset($attachment['filename'])) {
                    $mail->addStringAttachment(
                        $attachment['content'],
                        $attachment['filename'],
                        'base64',
                        $attachment['type'] ?? 'application/octet-stream'
                    );
                } elseif (isset($attachment['path']) && isset($attachment['filename'])) {
                    // Alternative: attach from file path
                    $mail->addAttachment(
                        $attachment['path'],
                        $attachment['filename'],
                        'base64',
                        $attachment['type'] ?? 'application/octet-stream'
                    );
                }
            }

            // Send with timeout
            $mail->send();

            Log::info("Email with attachments sent successfully to: $to", [
                'attachments_count' => count($attachments)
            ]);
            return true;

        } catch (\Exception $e) {
            Log::error("Email sending failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send reservation email specifically for AeroParking
     *
     * @param array $reservationData
     * @return bool
     */
    public function sendReservationEmail(array $reservationData)
    {
        $subject = 'Nova rezervacija: ' . $reservationData['name'];

        $content = $this->buildReservationEmailContent($reservationData);

        // Send to the reservations email
        return $this->sendEmail(
            config('mail.reservation.to', 'rezervacije@aeroparking.rs'),
            $subject,
            $content,
            'Rezervacije'
        );
    }

    /**
     * Build the HTML content for reservation email
     *
     * @param array $data
     * @return string
     */
    private function buildReservationEmailContent(array $data)
    {
        $name = htmlspecialchars($data['name'] ?? '', ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($data['email'] ?? '', ENT_QUOTES, 'UTF-8');
        $phone = htmlspecialchars($data['phone'] ?? '', ENT_QUOTES, 'UTF-8');
        $passengers = htmlspecialchars($data['passengers'] ?? '', ENT_QUOTES, 'UTF-8');
        $arrivalDate = htmlspecialchars($data['arrivalDate'] ?? '', ENT_QUOTES, 'UTF-8');
        $departureDate = htmlspecialchars($data['departureDate'] ?? '', ENT_QUOTES, 'UTF-8');
        $additionalInfo = htmlspecialchars($data['additionalInfo'] ?? '', ENT_QUOTES, 'UTF-8');

        return <<<EMAILBODY
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nova rezervacija</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f4f4f4; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .content { background-color: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #555; }
        .value { margin-left: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nova rezervacija - AeroParking</h2>
        </div>
        <div class="content">
            <div class="field">
                <span class="label">Ime:</span>
                <span class="value">{$name}</span>
            </div>
            <div class="field">
                <span class="label">Email:</span>
                <span class="value">{$email}</span>
            </div>
            <div class="field">
                <span class="label">Telefon:</span>
                <span class="value">{$phone}</span>
            </div>
            <div class="field">
                <span class="label">Datum i vreme dolaska:</span>
                <span class="value">{$arrivalDate}</span>
            </div>
            <div class="field">
                <span class="label">Datum i vreme odlaska:</span>
                <span class="value">{$departureDate}</span>
            </div>
            <div class="field">
                <span class="label">Broj putnika:</span>
                <span class="value">{$passengers}</span>
            </div>
            <div class="field">
                <span class="label">Dodatne napomene:</span>
                <span class="value">{$additionalInfo}</span>
            </div>
        </div>
    </div>
</body>
</html>
EMAILBODY;
    }
}
