<?php

namespace App\Livewire\Products\Coupons;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

class CouponCodeEdit extends Component
{
    public $products, $productId, $coupon, $couponId, $code, $name, $quantity, $discount, $type, $from, $to, $product = [];
    public function mount($couponId)
    {
        $this->coupon = Coupon::where('couponId', $couponId)->first();
        $this->products = Product::all();
        $this->code = $this->coupon->code;
        $this->name = $this->coupon->name;
        $this->quantity = $this->coupon->quantity;
        $this->discount = $this->coupon->amount;
        $this->type = $this->coupon->type;
        $this->from = $this->coupon->valid_from;
        $this->to = $this->coupon->valid_to;
        $this->product = $this->coupon->product_id;

    }
    public function update()
    {
        Coupon::where('couponId', $this->couponId)->update([
            'code' => $this->code,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'amount' => $this->discount,
            'type' => $this->type,
            'valid_from' => $this->from,
            'valid_to' => $this->to,
            'product_id' => $this->product
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
//        dd(Product::whereIn('code', $productCode)->first());
        return view('livewire.products.coupons.coupon-code-edit',[
            'products' => $this->products
        ]);
    }
}
