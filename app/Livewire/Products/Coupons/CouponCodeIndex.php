<?php

namespace App\Livewire\Products\Coupons;

use App\Models\Coupon;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class CouponCodeIndex extends Component
{
    use WithPagination;
    public $perPage = 5;
    public $coupon, $couponId;
    protected $listeners = ['deleteConfirmed' => 'delete'];

    public function deleteConfirm($couponId)
    {
        $this->couponId = $couponId;
        $this->dispatch('delete-confirmation');
    }
    public function delete()
    {
        $this->coupon = Coupon::where('couponId', $this->couponId)->first();
        $this->coupon->delete();
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Coupon deleted successfully!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('coupons.index', navigate: true);
    }
    #[Title('All Coupons')]
    public function render()
    {
        $couponCode = Coupon::all();
        return view('livewire.products.coupons.coupon-code-index',[
            'coupons' => Coupon::orderByDesc('created_at')->paginate($this->perPage)
        ]);
    }
}
