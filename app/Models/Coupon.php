<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function couponUsage()
    {
        return $this->hasMany(CouponUsage::class);
    }
}
