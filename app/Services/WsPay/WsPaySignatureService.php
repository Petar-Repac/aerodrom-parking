<?php

namespace App\Services\WsPay;


use PhpParser\Node\Stmt\DeclareDeclare;

class WsPaySignatureService
{
    private $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Generate signature for payment request
     */
    public function generatePaymentSignature(string $shopId, string $shoppingCartId, string $amount): string
    {
        $data = $shopId . $this->secretKey . $shoppingCartId . $this->secretKey . $amount . $this->secretKey;
        return hash('sha512', $data);
    }

    /**
     * Generate signature for completion request
     */
    public function generateCompletionSignature(string $shopId, string $wsPayOrderId, string $stan, string $approvalCode, string $amount): string
    {
        $data = $shopId . $wsPayOrderId . $this->secretKey . $stan . $this->secretKey . $approvalCode . $this->secretKey . $amount . $this->secretKey . $wsPayOrderId;
        return hash('sha512', $data);
    }

    /**
     * Generate signature for refund request
     */
    public function generateRefundSignature(string $shopId, string $wsPayOrderId, string $stan, string $approvalCode, string $amount): string
    {
        return $this->generateCompletionSignature($shopId, $wsPayOrderId, $stan, $approvalCode, $amount);
    }

    /**
     * Generate signature for void request
     */
    public function generateVoidSignature(string $shopId, string $wsPayOrderId, string $stan, string $approvalCode, string $amount): string
    {
        return $this->generateCompletionSignature($shopId, $wsPayOrderId, $stan, $approvalCode, $amount);
    }

    /**
     * Generate signature for status check request
     */
    public function generateStatusCheckSignature(string $shopId, string $shoppingCartId): string
    {
        $data = $shopId . $this->secretKey . $shoppingCartId . $this->secretKey . $shopId . $shoppingCartId;
        return hash('sha512', $data);
    }

    /**
     * Verify return URL signature (successful transaction)
     */
    public function verifyReturnSignature(array $data): bool
    {
        $expectedSignature = $this->generateReturnSignature(
            config('wspay.shop_id'),
            $data['ShoppingCartID'],
            $data['Success'],
            $data['ApprovalCode'] ?? ''
        );

        return hash_equals($expectedSignature, $data['Signature']);
    }

    /**
     * Verify error return URL signature
     */
    public function verifyErrorReturnSignature(array $data): bool
    {
        $expectedSignature = $this->generateReturnSignature(
            config('wspay.shop_id'),
            $data['ShoppingCartID'],
            $data['Success'],
            $data['ApprovalCode'] ?? ''
        );

        return hash_equals($expectedSignature, $data['Signature']);
    }

    /**
     * Verify cancel URL signature
     */
    public function verifyCancelSignature(array $data): bool
    {
        $expectedSignature = $this->generateReturnSignature(
            config('wspay.shop_id'),
            $data['ShoppingCartID'],
            $data['Success'],
            $data['ApprovalCode'] ?? ''
        );

        return hash_equals($expectedSignature, $data['Signature']);
    }

    /**
     * Verify completion response signature
     */
    public function verifyCompletionResponse(array $data): bool
    {
        $expectedSignature = $this->generateApiResponseSignature(
            $data['ShopID'],
            $data['STAN'],
            $data['ActionSuccess'],
            $data['ApprovalCode'],
            $data['WsPayOrderId']
        );

        return hash_equals($expectedSignature, $data['Signature']);
    }

    /**
     * Verify refund response signature
     */
    public function verifyRefundResponse(array $data): bool
    {
        return $this->verifyCompletionResponse($data);
    }

    /**
     * Verify void response signature
     */
    public function verifyVoidResponse(array $data): bool
    {
        return $this->verifyCompletionResponse($data);
    }

    /**
     * Verify status check response signature
     */
    public function verifyStatusCheckResponse(array $data): bool
    {
        $expectedSignature = $this->generateStatusCheckResponseSignature(
            $data['ShopID'],
            $data['ActionSuccess'],
            $data['ApprovalCode'] ?? '',
            $data['WsPayOrderId']
        );

        return hash_equals($expectedSignature, $data['Signature']);
    }

    private function generateReturnSignature(string $shopId, string $shoppingCartId, string $success, string $approvalCode): string
    {
        $data = $shopId . $this->secretKey . $shoppingCartId . $this->secretKey . $success . $this->secretKey . $approvalCode . $this->secretKey;
        return hash('sha512', $data);
    }

    private function generateApiResponseSignature(string $shopId, string $stan, string $actionSuccess, string $approvalCode, string $wsPayOrderId): string
    {
        $data = $shopId . $this->secretKey . $stan . $actionSuccess . $this->secretKey . $approvalCode . $wsPayOrderId;
        return hash('sha512', $data);
    }

    private function generateStatusCheckResponseSignature(string $shopId, string $actionSuccess, string $approvalCode, string $wsPayOrderId): string
    {
        $data = $shopId . $this->secretKey . $actionSuccess . $approvalCode . $this->secretKey . $shopId . $approvalCode . $wsPayOrderId;
        return hash('sha512', $data);
    }
}
