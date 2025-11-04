<?php

namespace App\DTOs;

use Carbon\Carbon;

class PaymentDetailsDTO
{
    public string $method;
    public bool $applyDiscount;
    public ?float $discountPercentage;
    public float $discountAmount;
    public float $totalPrice;

    // Payment transaction fields (all optional)
    public ?string $wsPayOrderId;
    public ?string $approvalCode;
    public ?string $stan;
    public ?float $paymentAmount;
    public ?string $paymentDate;
    public ?string $creditCardNumber;
    public ?string $paymentStatus;

    public function __construct(array $data)
    {
        // Original fields
        $this->method = $data['method'];
        $this->applyDiscount = $data['applyDiscount'];
        $this->discountPercentage = $data['discountPercentage'] ?? null;
        $this->discountAmount = (float)($data['discountAmount'] ?? 0);
        $this->totalPrice = (float)($data['totalPrice']);

        // Payment transaction fields (optional)
        $this->wsPayOrderId = $data['wsPayOrderId'] ?? $data['ws_pay_order_id'] ?? null;
        $this->approvalCode = $data['approvalCode'] ?? $data['approval_code'] ?? null;
        $this->stan = $data['stan'] ?? null;
        $this->paymentAmount = isset($data['paymentAmount']) ? (float)$data['paymentAmount'] :
            (isset($data['payment_amount']) ? (float)$data['payment_amount'] : null);
        $this->paymentDate = $data['paymentDate'] ?? $data['payment_date'] ?? null;
        $this->creditCardNumber = $data['creditCardNumber'] ?? $data['credit_card_number'] ?? null;
        $this->paymentStatus = $data['paymentStatus'] ?? $data['payment_status'] ?? null;
    }

    public function getMethodFormatted(): string
    {
        return ucfirst(str_replace(['payment-', '-'], ['', ' '], $this->method));
    }

    public function getTotalPriceFormatted(): string
    {
        return '€ ' . number_format($this->totalPrice, 2);
    }

    public function getDiscountAmountFormatted(): string
    {
        return '€ ' . number_format($this->discountAmount, 2);
    }

    public function getPaymentAmountFormatted(): ?string
    {
        return $this->paymentAmount ? '€ ' . number_format($this->paymentAmount, 2) : null;
    }

    public function getPaymentDateFormatted(): ?string
    {
        if (!$this->paymentDate) {
            return null;
        }

        try {
            return Carbon::parse($this->paymentDate)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return $this->paymentDate;
        }
    }

    public function getMaskedCreditCardNumber(): ?string
    {
        if (!$this->creditCardNumber) {
            return null;
        }

        // Mask all but last 4 digits
        $length = strlen($this->creditCardNumber);
        if ($length < 4) {
            return str_repeat('*', $length);
        }

        return str_repeat('*', $length - 4) . substr($this->creditCardNumber, -4);
    }

    public function hasPaymentDetails(): bool
    {
        return !empty($this->wsPayOrderId) || !empty($this->approvalCode);
    }

    public function isPaymentCompleted(): bool
    {
        return $this->paymentStatus === 'completed' ||
            ($this->hasPaymentDetails() && !empty($this->approvalCode));
    }

    public function toArray(): array
    {
        return [
            'payment_method' => $this->method,
            'apply_discount' => $this->applyDiscount,
            'discount_percentage' => $this->discountPercentage,
            'discount_amount' => $this->discountAmount,
            'total_price' => $this->totalPrice,
            'ws_pay_order_id' => $this->wsPayOrderId,
            'approval_code' => $this->approvalCode,
            'stan' => $this->stan,
            'payment_amount' => $this->paymentAmount,
            'payment_date' => $this->paymentDate,
            'credit_card_number' => $this->creditCardNumber,
            'payment_status' => $this->paymentStatus,
        ];
    }

    public function updatePaymentDetails(array $paymentDetails): void
    {
        $this->wsPayOrderId = $paymentDetails['ws_pay_order_id'] ?? $this->wsPayOrderId;
        $this->approvalCode = $paymentDetails['approval_code'] ?? $this->approvalCode;
        $this->stan = $paymentDetails['stan'] ?? $this->stan;
        $this->paymentAmount = isset($paymentDetails['payment_amount']) ?
            (float)$paymentDetails['payment_amount'] : $this->paymentAmount;
        $this->paymentDate = $paymentDetails['payment_date'] ?? $this->paymentDate;
        $this->creditCardNumber = $paymentDetails['credit_card_number'] ?? $this->creditCardNumber;
        $this->paymentStatus = $paymentDetails['payment_status'] ?? 'completed';
    }
}
