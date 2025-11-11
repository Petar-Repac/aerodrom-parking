<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_id')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->integer('passengers');
            $table->date('arrival_date');
            $table->date('departure_date');
            $table->integer('num_of_days');
            $table->decimal('total_price', 10, 2);
            $table->text('additional_info')->nullable();
            $table->string('payment_method'); // 'payment-onsite' or 'payment-online'
            $table->string('status')->default('pending'); // pending, paid, payment_failed, cancelled

            // Payment details (nullable for on-site payments)
            $table->string('ws_pay_order_id')->nullable();
            $table->string('approval_code')->nullable();
            $table->string('stan')->nullable();
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('credit_card_number')->nullable();
            $table->string('payment_status')->nullable();
            $table->text('error_message')->nullable();

            $table->timestamps();

            // Indexes for faster lookups
            $table->index('reservation_id');
            $table->index('email');
            $table->index('status');
            $table->index('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
