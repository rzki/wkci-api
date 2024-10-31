<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('transactionId')->nullable();
            $table->string('trx_ref_no')->nullable();
            $table->string('partner_ref_no')->nullable();
            $table->string('participant_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('paid_at')->nullable();
            $table->tinyText('trx_proof')->nullable();
            $table->string('amount');
            $table->timestamp('submitted_date')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
