<?php

namespace App\Livewire\Transactions;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Title;

class TransactionManualQR extends Component
{
    public $name, $amount;

    public function submitData()
    {
        $trx = Transaction::create([
            'transactionId' => Str::orderedUuid(),
            'participant_name' => $this->name,
            'amount' => $this->amount
        ]);
        Cache::put('manualQR', $trx);
        return to_route('generate_manual_qr', [
            'amount' => base64_encode($this->amount)
        ]);
    }
    #[Title('Create Manual Transaction')]
    public function render()
    {
        return view('livewire.transactions.transaction-manual-q-r');
    }
}
