<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;

class ProductCreate extends Component
{
    public $code, $name, $desc, $day, $type, $date, $start_time, $end_time, $price;

    public function create()
    {
        Product::create([
            'productId' => Str::orderedUuid(),
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
