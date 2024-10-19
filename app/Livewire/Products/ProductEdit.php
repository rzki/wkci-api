<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductEdit extends Component
{
    public $product, $productId,$name, $day, $type, $date, $price;
    public function mount($productId)
    {
        $this->product = Product::where('productId', $productId)->first();
        $this->name = $this->product->name;
        $this->day = $this->product->day;
        $this->type = $this->product->type;
        $this->date = $this->product->date;
        $this->price = $this->product->price;
    }
    public function update()
    {
        Product::where('productId', $this->productId)->update([
            'name' => $this->name,
            'date' => $this->date,
            'price' => $this->price,
            'day' => $this->day,
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
