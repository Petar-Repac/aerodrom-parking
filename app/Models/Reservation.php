<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'name',
        'email',
        'phone',
        'passengers',
        'arrival_date',
        'arrival_time',
        'departure_date',
        'departure_time',
        'num_of_days',
        'total_price',
        'additional_info',
        'payment_method',
        'status',
        'ws_pay_order_id',
        'approval_code',
        'stan',
        'payment_amount',
        'payment_date',
        'credit_card_number',
        'payment_status',
        'error_message',
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'departure_date' => 'date',
        'payment_date' => 'datetime',
        'total_price' => 'decimal:2',
        'payment_amount' => 'decimal:2',
        'passengers' => 'integer',
        'num_of_days' => 'integer',
    ];

    /**
     * Get formatted total price
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return number_format($this->total_price, 2) . ' RSD';
    }

    /**
     * Get formatted payment amount
     */
    public function getFormattedPaymentAmountAttribute(): ?string
    {
        return $this->payment_amount ? number_format($this->payment_amount, 2) . ' RSD' : null;
    }

    /**
     * Get masked credit card number
     */
    public function getMaskedCardNumberAttribute(): ?string
    {
        if (!$this->credit_card_number) {
            return null;
        }

        $length = strlen($this->credit_card_number);
        if ($length < 4) {
            return str_repeat('*', $length);
        }

        return str_repeat('*', $length - 4) . substr($this->credit_card_number, -4);
    }

    /**
     * Check if payment was completed
     */
    public function isPaymentCompleted(): bool
    {
        return $this->status === 'paid' && !empty($this->approval_code);
    }

    /**
     * Check if payment is pending
     */
    public function isPaymentPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment failed
     */
    public function isPaymentFailed(): bool
    {
        return $this->status === 'payment_failed';
    }

    /**
     * Scope for online payments
     */
    public function scopeOnlinePayments($query)
    {
        return $query->where('payment_method', 'payment-online');
    }

    /**
     * Scope for on-site payments
     */
    public function scopeOnsitePayments($query)
    {
        return $query->where('payment_method', 'payment-onsite');
    }

    /**
     * Scope for paid reservations
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope for pending reservations
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
