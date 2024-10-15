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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transactionId');
            $table->string('referenceNo');
            $table->string('partnerReferenceNo');
            $table->string('name_str');
            $table->string('full_name');
            $table->string('email');
            $table->string('nik');
            $table->string('npa');
            $table->string('cabang_pdgi');
            $table->string('phone_number');
            $table->string('amount');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
