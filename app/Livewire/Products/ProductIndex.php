<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;
    public $perPage = 5;
    public $product, $productId;
    protected $listeners = ['deleteConfirmed' => 'delete'];

    public function deleteConfirm($productId)
    {
        $this->productId = $productId;
        $this->dispatch('delete-confirmation');
    }
    public function delete()
    {
        $this->product = Product::where('productId', $this->productId)->first();
        $this->product->delete();
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Product deleted successfully!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 1500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('products.index', navigate: true);
    }
    #[Title('All Products')]
    public function render()
    {
        return view('livewire.products.product-index',[
            'products' => Product::orderByDesc('created_at')
            ->paginate($this->perPage)
        ]);
    }
}
