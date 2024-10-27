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
            $table->string('cabang_pdgi');
            $table->string('phone_number');
            $table->string('seminar')->nullable();
            $table->string('attended')->nullable();
            $table->string('amount')->nullable();
            $table->tinyText('barcode')->nullable();
            $table->string('form_type');
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
