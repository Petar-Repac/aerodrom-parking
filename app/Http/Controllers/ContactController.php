<?php

namespace App\Http\Controllers;

use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    protected $emailService;

    /**
     * Create a new controller instance.
     *
     * @param EmailService $emailService
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Display the contact form
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.contact');
    }

    /**
     * Handle the contact form submission
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        // Validate form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get validated form data
            $name = $request->input('name');
            $phone = $request->input('phone');
            $email = $request->input('email');
            $message = $request->input('message');

            // Prepare email content
            $subject = "Aeroparking.rs - New Contact Message";
            $content = $this->buildEmailContent($name, $phone, $email, $message);

            // Send to company email
            $recipientEmail = config('mail.contact.address');
            $result = $this->emailService->sendEmail($recipientEmail, $subject, $content);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your message has been sent successfully!'
                ]);
            } else {
                Log::error("Failed to send contact email from {$email}");
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send the message. Please try again later.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error("Contact form exception: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.'
            ], 500);
        }
    }

    /**
     * Build HTML email content
     *
     * @param string $name
     * @param string $phone
     * @param string $email
     * @param string $message
     * @return string
     */
    private function buildEmailContent($name, $phone, $email, $message)
    {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }
                h2 {
                    color: #4f46e5;
                }
                .details {
                    margin-bottom: 20px;
                }
                .details p {
                    margin: 5px 0;
                }
                .message-box {
                    background-color: #f9f9f9;
                    padding: 15px;
                    border-radius: 5px;
                    margin-top: 20px;
                }
                .label {
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2>New Contact Message</h2>
                <div class="details">
                    <p><span class="label">Name:</span> ' . htmlspecialchars($name) . '</p>
                    <p><span class="label">Phone:</span> ' . htmlspecialchars($phone) . '</p>
                    <p><span class="label">Email:</span> ' . htmlspecialchars($email) . '</p>
                </div>
                <div class="message-box">
                    <p><span class="label">Message:</span></p>
                    <p>' . nl2br(htmlspecialchars($message)) . '</p>
                </div>
                <p>This message was sent from the Aeroparking.rs website contact form.</p>
            </div>
        </body>
        </html>';
    }
}
