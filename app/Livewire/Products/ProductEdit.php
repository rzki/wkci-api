<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;

class ProductEdit extends Component
{
    public $product, $productId, $code, $name, $desc, $day, $type, $date, $start_time, $end_time, $price;
    public function mount($productId)
    {
        $this->product = Product::where('productId', $productId)->first();
        $this->code = $this->product->code;
        $this->name = $this->product->name;
        $this->desc = $this->product->description;
        $this->day = $this->product->day;
        $this->type = $this->product->type;
        $this->date = $this->product->date;
        $this->start_time = $this->product->start_time;
        $this->end_time = $this->product->end_time;
        $this->price = $this->product->price;
    }
    public function update()
    {
        Product::where('productId', $this->productId)->update([
            'code' => $this->code,
            'name' => $this->name,
            'description' => ucwords($this->desc),
            'date' => $this->date,
            'price' => $this->price,
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'type' => $this->type
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Product successfully updated!',
            'toast'=> true,
            'position'=> 'top-end',
            'timer'=> 3000,
            'progbar' => true,
            'showConfirmButton'=> false
        ]);

        return $this->redirectRoute('products.index', navigate:true);
    }
    #[Title('Edit Product')]
    public function render()
    {
        return view('livewire.products.product-edit');
    }
}
