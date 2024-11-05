<?php

namespace App\Livewire\Products\Coupons;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

class CouponCodeCreate extends Component
{
    public $products, $product, $code, $name, $quantity, $discount, $type, $from, $to;
    public function mount()
    {
        $this->products = Product::all();
    }
    public function create()
    {
        Coupon::create([
            'couponId' => Str::orderedUuid(),
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
            'title' => 'Coupon successfully added!',
            'toast'=> true,
            'position'=> 'top-end',
            'timer'=> 3000,
            'progbar' => true,
            'showConfirmButton'=> false
        ]);

        return $this->redirectRoute('coupons.index', navigate:true);
    }
    #[Title('Add New Coupon')]
    public function render()
    {
        return view('livewire.products.coupons.coupon-code-create',[
            'products' => $this->products
        ]);
    }
}
