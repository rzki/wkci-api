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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->uuid('formId');
            $table->string('name_str');
            $table->string('full_name');
            $table->string('email');
            $table->string('nik');
            $table->string('npa');
            $table->string('cabang_pdgi')->nullable();
            $table->string('phone_number');
            $table->string('seminar')->nullable();
            $table->string('attended')->nullable();
            $table->string('amount')->nullable();
            $table->string('trx_history')->nullable();
            $table->text('barcode')->nullable();
            $table->string('trx_no')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->string('status')->nullable();
            $table->string('applied_coupon')->nullable();
            $table->timestamp('submitted_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
