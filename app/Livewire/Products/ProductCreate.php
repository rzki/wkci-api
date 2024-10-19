<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;

class ProductCreate extends Component
{
    public $name, $day, $type, $date, $price;

    public function create()
    {
        Product::create([
            'productId' => Str::orderedUuid(),
            'name' => $this->name,
            'date' => $this->date,
            'type' => $this->type,
            'price' => $this->price,
            'day' => $this->day
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Product successfully added!',
            'toast'=> true,
            'position'=> 'top-end',
            'timer'=> 3000,
            'progbar' => true,
            'showConfirmButton'=> false
        ]);

        return $this->redirectRoute('products.index', navigate:true);
    }
    #[Title('Add New Product')]
    public function render()
    {
        return view('livewire.products.product-create');
    }
}
