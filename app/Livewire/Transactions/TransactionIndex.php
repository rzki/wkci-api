<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionIndex extends Component
{
    use WithPagination;
    public $trx, $transactionId;
    public $perPage= 5, $search;
    protected $listeners = ['deleteConfirmed' => 'delete'];
    public function deleteConfirm($transactionId)
    {
        $this->transactionId = $transactionId;
        $this->dispatch('delete-confirmation');
    }
    public function delete()
    {
        $this->trx = Transaction::where('transactionId', $this->transactionId)->first();
        $this->trx->delete();
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Transaction history deleted successfully!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('transactions.index', navigate: true);
    }
    #[Title('All Transaction History')]
    public function render()
    {
        return view('livewire.transactions.transaction-index',[
            'transactions' => Transaction::search($this->search)
                            ->orderByDesc('created_at')
                            ->paginate($this->perPage)
        ]);
    }
}
