<?php

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coupons_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Coupon::class)->constrained('coupons', 'id', 'coupon_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(User::class)->constrained('users', 'id', 'user_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('usage_count')->default(0);
            $table->timestamps();
        });

    }
    public function down(): void
    {
        Schema::dropIfExists('coupons_usages');
    }
};
