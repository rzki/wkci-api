<?php

namespace App\Livewire\Transactions;

use App\Exports\HandsOnFormExport;
use App\Exports\TransactionExport;
use App\Models\Transaction;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TransactionIndex extends Component
{
    use WithPagination;
    public $trx, $transactionId;
    public $perPage= 5, $search, $start_date = '', $end_date = '';
    public $selectedItems = [];
    protected $listeners = ['deleteConfirmed' => 'delete'];
    public function deleteSelected()
    {
        // Delete the selected items
        Transaction::whereIn('id', $this->selectedItems)->delete();
        // Reset selected items and reload the items
        $this->selectedItems = [];
        session()->flash('alert',  [
            'type' => 'success',
            'title' => 'Selected transaction histories deleted successfully!',
            'toast' => true,
            'position' => 'top-right',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('transactions.index', navigate: true);
    }
    public function deleteConfirm($transactionId)
    {
        $this->transactionId = $transactionId;
        $this->dispatch('delete-confirmation');
    }
    public function delete()
    {
        $this->trx = Transaction::where('transactionId', $this->transactionId)->first();
        $this->trx->delete();
        Storage::disk('public')->delete($this->trx->barcode);
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
    public function export()
    {
        $filename = 'JADE_Transaction_'.date('d-m-Y').'.xlsx';
        return Excel::download(new TransactionExport($this->start_date, $this->end_date), $filename);
    }

    public function updatePaymentStatus($transactionId)
    {
        $this->transactionId = $transactionId;
        $this->trx = Transaction::where('transactionId', $transactionId)->first();
        return $this->redirectRoute('query_payment_status', [
            'transactionId' => base64_encode($this->trx->transactionId),
            'trx' => base64_encode($this->trx->partner_ref_no),
            'refNo' => base64_encode($this->trx->trx_ref_no)
        ]);
    }
    #[Title('All Transaction History')]
    public function render()
    {
        return view('livewire.transactions.transaction-index',[
            'transactions' => Transaction::search($this->search)
                ->when($this->start_date !== '' && $this->end_date !== '', function ($query) {
                    $query->WhereDate('submitted_date', '>=', $this->start_date)
                        ->WhereDate('submitted_date', '<=', $this->end_date);
                })
                ->orderByDesc('submitted_date')
                ->paginate($this->perPage)
        ]);
    }
}
