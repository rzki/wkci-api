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
        Schema::create('form_participants', function (Blueprint $table) {
            $table->id();
            $table->uuid('formId');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('origin');
            $table->text('barcode')->nullable();
            $table->timestamp('submitted_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_participants');
    }
};
