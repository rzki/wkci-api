<?php

namespace App\Livewire\Products\Coupons;

use App\Models\Coupon;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

class CouponCodeEdit extends Component
{
    public $coupon, $couponId, $code, $name, $quantity, $discount, $from, $to;
    public function mount($couponId)
    {
        $this->coupon = Coupon::where('couponId', $couponId)->first();
        $this->code = $this->coupon->code;
        $this->name = $this->coupon->name;
        $this->quantity = $this->coupon->quantity;
        $this->discount = $this->coupon->discount;
        $this->from = $this->coupon->valid_from;
        $this->to = $this->coupon->valid_to;
    }
    public function update()
    {
        Coupon::where('couponId', $this->couponId)->update([
            'code' => $this->code,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'discount' => $this->discount,
            'valid_from' => $this->from,
            'valid_to' => $this->to,
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Coupon successfully updated!',
            'toast'=> true,
            'position'=> 'top-end',
            'timer'=> 3000,
            'progbar' => true,
            'showConfirmButton'=> false
        ]);

        return $this->redirectRoute('coupons.index', navigate:true);
    }
    #[Title('Edit Coupon')]
    public function render()
    {
        return view('livewire.products.coupons.coupon-code-edit');
    }
}
