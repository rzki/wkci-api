<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    protected $guarded = ['id'];

    public function userCoupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function couponUser()
    {
        return $this->belongsTo(User::class);
    }
}
