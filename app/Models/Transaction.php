<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];
    protected function casts(): array
    {
        return [
            'transactionId' => 'string',
        ];
    }

    public function scopeSearch($query, $value)
    {
        $query->where('participant_name', 'like', "%{$value}%")
            ->orWhere('partner_ref_no', 'like', "%{$value}%")
            ->orWhere('trx_ref_no', 'like', "%{$value}%");
    }
}
