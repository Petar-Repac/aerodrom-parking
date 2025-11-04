<?php

namespace App\Services\WsPay;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\WsPay\WsPaySignatureService;
use App\Services\WsPay\Exceptions\WsPayException;

class WsPayService
{
    private $shopId;
    private $secretKey;
    private $testMode;
    private $version;
    private $signatureService;

    public function __construct()
    {
        $this->shopId = config('wspay.shop_id');
        $this->secretKey = config('wspay.secret_key');
        $this->testMode = config('wspay.test_mode');
        $this->version = config('wspay.version');
        $this->signatureService = new WsPaySignatureService($this->secretKey);
    }

    /**
     * Create payment URL using WSPay "Create Transaction" API (RECOMMENDED)
     * Uses POST request to API endpoint, returns payment URL
     */
    public function createPayment(array $paymentData): string
    {
        $requiredFields = ['shopping_cart_id', 'total_amount', 'return_url', 'return_error_url', 'cancel_url'];

        foreach ($requiredFields as $field) {
            if (empty($paymentData[$field])) {
                throw new WSPayException("Missing required field: {$field}");
            }
        }

        // Use the Create Transaction API (POST method)
        $response = $this->createTransaction($paymentData);
        // Extract the payment URL from the API response
        if (isset($response['payment_url'])) {
            return $response['payment_url'];
        } elseif (isset($response['url'])) {
            return $response['url'];
        }
        elseif (isset($response['PaymentFormUrl'])) {
            return $response['PaymentFormUrl'];
        }
        else {
            // If API doesn't return direct URL, construct it from the response
            throw new WSPayException('No payment URL returned from WSPay API');
        }
    }

    /**
     * Create payment URL using direct form method (Alternative approach)
     * Uses GET parameters - less secure but simpler
     */
    public function createPaymentDirect(array $paymentData): string
    {
        $requiredFields = ['shopping_cart_id', 'total_amount', 'return_url', 'return_error_url', 'cancel_url'];

        foreach ($requiredFields as $field) {
            if (empty($paymentData[$field])) {
                throw new WSPayException("Missing required field: {$field}");
            }
        }

        $formData = [
            'ShopID' => $this->shopId,
            'ShoppingCartID' => $paymentData['shopping_cart_id'],
            'Version' => $this->version,
            'TotalAmount' => $this->formatAmount($paymentData['total_amount']),
            'ReturnURL' => $paymentData['return_url'],
            'ReturnErrorURL' => $paymentData['return_error_url'],
            'CancelURL' => $paymentData['cancel_url'],
        ];

        // Add optional parameters
        $optionalFields = [
            'Lang' => 'lang',
            'CustomerFirstName' => 'customer_first_name',
            'CustomerLastName' => 'customer_last_name',
            'CustomerAddress' => 'customer_address',
            'CustomerCity' => 'customer_city',
            'CustomerZIP' => 'customer_zip',
            'CustomerCountry' => 'customer_country',
            'CustomerEmail' => 'customer_email',
            'CustomerPhone' => 'customer_phone',
            'PaymentPlan' => 'payment_plan',
            'CreditCardName' => 'credit_card_name',
        ];

        foreach ($optionalFields as $wspayField => $dataField) {
            if (!empty($paymentData[$dataField])) {
                $formData[$wspayField] = $paymentData[$dataField];
            }
        }

        // Generate signature
        $formData['Signature'] = $this->signatureService->generatePaymentSignature(
            $this->shopId,
            $paymentData['shopping_cart_id'],
            $this->formatAmountForSignature($paymentData['total_amount'])
        );

        return $this->buildFormUrl($formData);
    }

    /**
     * Generate HTML form for payment submission (alternative to direct redirect)
     */
    public function generatePaymentForm(array $paymentData, array $options = []): string
    {
        $requiredFields = ['shopping_cart_id', 'total_amount', 'return_url', 'return_error_url', 'cancel_url'];

        foreach ($requiredFields as $field) {
            if (empty($paymentData[$field])) {
                throw new WSPayException("Missing required field: {$field}");
            }
        }

        $formData = [
            'ShopID' => $this->shopId,
            'ShoppingCartID' => $paymentData['shopping_cart_id'],
            'Version' => $this->version,
            'TotalAmount' => $this->formatAmount($paymentData['total_amount']),
            'ReturnURL' => $paymentData['return_url'],
            'ReturnErrorURL' => $paymentData['return_error_url'],
            'CancelURL' => $paymentData['cancel_url'],
        ];

        // Add optional parameters
        $optionalFields = [
            'Lang' => 'lang',
            'CustomerFirstName' => 'customer_first_name',
            'CustomerLastName' => 'customer_last_name',
            'CustomerAddress' => 'customer_address',
            'CustomerCity' => 'customer_city',
            'CustomerZIP' => 'customer_zip',
            'CustomerCountry' => 'customer_country',
            'CustomerEmail' => 'customer_email',
            'CustomerPhone' => 'customer_phone',
            'PaymentPlan' => 'payment_plan',
            'CreditCardName' => 'credit_card_name',
        ];

        foreach ($optionalFields as $wspayField => $dataField) {
            if (!empty($paymentData[$dataField])) {
                $formData[$wspayField] = $paymentData[$dataField];
            }
        }

        // Generate signature
        $formData['Signature'] = $this->signatureService->generatePaymentSignature(
            $this->shopId,
            $paymentData['shopping_cart_id'],
            $this->formatAmountForSignature($paymentData['total_amount'])
        );

        // Build HTML form
        $formAction = $this->getApiUrl('form');
        $formId = $options['form_id'] ?? 'wspay-payment-form';
        $submitText = $options['submit_text'] ?? 'Pay Now';
        $autoSubmit = $options['auto_submit'] ?? false;

        $html = "<form id=\"{$formId}\" action=\"{$formAction}\" method=\"POST\">\n";

        foreach ($formData as $name => $value) {
            $html .= "    <input type=\"hidden\" name=\"{$name}\" value=\"" . htmlspecialchars($value) . "\">\n";
        }

        $html .= "    <input type=\"submit\" value=\"{$submitText}\">\n";
        $html .= "</form>\n";

        if ($autoSubmit) {
            $html .= "<script>document.getElementById('{$formId}').submit();</script>\n";
        }

        return $html;
    }

    /**
     * Create transaction via API (POST method to /api/create-transaction)
     */
    public function createTransaction(array $paymentData): array
    {
        $url = $this->getApiUrl('create_transaction');

        $requestData = [
            'ShopID' => $this->shopId,
            'ShoppingCartID' => $paymentData['shopping_cart_id'],
            'Version' => $this->version,
            'TotalAmount' => $this->formatAmount($paymentData['total_amount']),
            'ReturnURL' => $paymentData['return_url'],
            'ReturnErrorURL' => $paymentData['return_error_url'],
            'CancelURL' => $paymentData['cancel_url'],
        ];

        // Add optional parameters
        $optionalFields = [
            'Lang' => 'lang',
            'CustomerFirstName' => 'customer_first_name',
            'CustomerLastName' => 'customer_last_name',
            'CustomerAddress' => 'customer_address',
            'CustomerCity' => 'customer_city',
            'CustomerZIP' => 'customer_zip',
            'CustomerCountry' => 'customer_country',
            'CustomerEmail' => 'customer_email',
            'CustomerPhone' => 'customer_phone',
            'PaymentPlan' => 'payment_plan',
            'CreditCardName' => 'credit_card_name',
        ];

        foreach ($optionalFields as $wspayField => $dataField) {
            if (!empty($paymentData[$dataField])) {
                $requestData[$wspayField] = $paymentData[$dataField];
            }
        }

        // Generate signature for create transaction
        $requestData['Signature'] = $this->signatureService->generatePaymentSignature(
            $this->shopId,
            $paymentData['shopping_cart_id'],
            $this->formatAmountForSignature($paymentData['total_amount'])
        );

        $response = Http::post($url, $requestData);

        if (!$response->successful()) {
            throw new WSPayException('Failed to create transaction: ' . $response->body());
        }

        $responseData = $response->json();

        // Based on WSPay docs, the response should contain a URL to redirect to
        // The exact response format may vary, so we'll handle common cases
        if (!$responseData) {
            throw new WSPayException('Invalid response from WSPay create transaction API');
        }

        return $responseData;
    }

    /**
     * Complete a pre-authorized transaction
     */
    public function completeTransaction(string $wsPayOrderId, string $approvalCode, string $stan, string $amount): array
    {
        $url = $this->getApiUrl('api') . '/completion';

        $requestData = [
            'Version' => $this->version,
            'WsPayOrderId' => $wsPayOrderId,
            'ShopID' => $this->shopId,
            'ApprovalCode' => $approvalCode,
            'STAN' => $stan,
            'Amount' => $this->formatAmountForSignature($amount),
        ];

        $requestData['Signature'] = $this->signatureService->generateCompletionSignature(
            $this->shopId,
            $wsPayOrderId,
            $stan,
            $approvalCode,
            $requestData['Amount']
        );

        $response = Http::post($url, $requestData);

        if (!$response->successful()) {
            throw new WSPayException('Failed to complete transaction: ' . $response->body());
        }

        $responseData = $response->json();

        // Verify response signature
        if (!$this->signatureService->verifyCompletionResponse($responseData)) {
            throw new WSPayException('Invalid response signature');
        }

        return $responseData;
    }

    /**
     * Refund a completed transaction
     */
    public function refundTransaction(string $wsPayOrderId, string $approvalCode, string $stan, string $amount): array
    {
        $url = $this->getApiUrl('api') . '/refund';

        $requestData = [
            'Version' => $this->version,
            'WsPayOrderId' => $wsPayOrderId,
            'ShopID' => $this->shopId,
            'ApprovalCode' => $approvalCode,
            'STAN' => $stan,
            'Amount' => $this->formatAmountForSignature($amount),
        ];

        $requestData['Signature'] = $this->signatureService->generateRefundSignature(
            $this->shopId,
            $wsPayOrderId,
            $stan,
            $approvalCode,
            $requestData['Amount']
        );

        $response = Http::post($url, $requestData);

        if (!$response->successful()) {
            throw new WSPayException('Failed to refund transaction: ' . $response->body());
        }

        $responseData = $response->json();

        // Verify response signature
        if (!$this->signatureService->verifyRefundResponse($responseData)) {
            throw new WSPayException('Invalid response signature');
        }

        return $responseData;
    }

    /**
     * Void an authorized transaction
     */
    public function voidTransaction(string $wsPayOrderId, string $approvalCode, string $stan, string $amount): array
    {
        $url = $this->getApiUrl('api') . '/void';

        $requestData = [
            'Version' => $this->version,
            'WsPayOrderId' => $wsPayOrderId,
            'ShopID' => $this->shopId,
            'ApprovalCode' => $approvalCode,
            'STAN' => $stan,
            'Amount' => $this->formatAmountForSignature($amount),
        ];

        $requestData['Signature'] = $this->signatureService->generateVoidSignature(
            $this->shopId,
            $wsPayOrderId,
            $stan,
            $approvalCode,
            $requestData['Amount']
        );

        $response = Http::post($url, $requestData);

        if (!$response->successful()) {
            throw new WSPayException('Failed to void transaction: ' . $response->body());
        }

        $responseData = $response->json();

        // Verify response signature
        if (!$this->signatureService->verifyVoidResponse($responseData)) {
            throw new WSPayException('Invalid response signature');
        }

        return $responseData;
    }

    /**
     * Check transaction status
     */
    public function checkTransactionStatus(string $shoppingCartId): array
    {
        $url = $this->getApiUrl('api') . '/statusCheck';

        $requestData = [
            'Version' => $this->version,
            'ShopID' => $this->shopId,
            'ShoppingCartID' => $shoppingCartId,
        ];

        $requestData['Signature'] = $this->signatureService->generateStatusCheckSignature(
            $this->shopId,
            $shoppingCartId
        );

        $response = Http::post($url, $requestData);

        if (!$response->successful()) {
            throw new WSPayException('Failed to check transaction status: ' . $response->body());
        }

        $responseData = $response->json();

        // Verify response signature
        if (!$this->signatureService->verifyStatusCheckResponse($responseData)) {
            throw new WSPayException('Invalid response signature');
        }

        return $responseData;
    }

    /**
     * Verify callback/return data
     */
    public function verifyCallback(array $callbackData): bool
    {
        if (isset($callbackData['Success']) && $callbackData['Success'] == '1') {
            return $this->signatureService->verifyReturnSignature($callbackData);
        } elseif (isset($callbackData['Success']) && $callbackData['Success'] == '0') {
            return $this->signatureService->verifyErrorReturnSignature($callbackData);
        } elseif (isset($callbackData['ResponseCode'])) {
            return $this->signatureService->verifyCancelSignature($callbackData);
        }

        return false;
    }

    /**
     * Process callback data
     */
    public function processCallback(array $callbackData): array
    {
        if (!$this->verifyCallback($callbackData)) {
            throw new WSPayException('Invalid callback signature');
        }

        return [
            'success' => $callbackData['Success'] ?? '0',
            'shopping_cart_id' => $callbackData['ShoppingCartID'] ?? null,
            'approval_code' => $callbackData['ApprovalCode'] ?? null,
            'amount' => $callbackData['Amount'] ?? null,
            'ws_pay_order_id' => $callbackData['WsPayOrderId'] ?? null,
            'stan' => $callbackData['STAN'] ?? null,
            'error_message' => $callbackData['ErrorMessage'] ?? null,
            'response_code' => $callbackData['ResponseCode'] ?? null,
            'payment_type' => $callbackData['PaymentType'] ?? null,
            'credit_card_number' => $callbackData['CreditCardNumber'] ?? null,
            'datetime' => $callbackData['DateTime'] ?? null,
        ];
    }

    private function formatAmount(float $amount): string
    {
        return number_format($amount, 2, ',', '');
    }

    private function formatAmountForSignature(float $amount): string
    {
        return str_replace(['.', ','], '', number_format($amount, 2, '.', ''));
    }

    private function getApiUrl(string $type): string
    {
        $environment = $this->testMode ? 'test' : 'production';
        return config("wspay.urls.{$environment}.{$type}");
    }

    private function buildFormUrl(array $formData): string
    {
        $baseUrl = $this->getApiUrl('form');
        return $baseUrl . '?' . http_build_query($formData);
    }
}
