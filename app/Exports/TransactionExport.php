<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class TransactionExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $start_date, $end_date;
    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        return Transaction::query()
            ->when($this->start_date, function ($query) {
                $query->whereDate('submitted_date', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                $query->whereDate('submitted_date', '<=', $this->end_date);
            })->get();
    }

    public function map($trx): array
    {
        return [
            $trx->trx_ref_no ?? '',
            $trx->partner_ref_no?? '',
            $trx->participant_name ?? '',
            $trx->phone_number ?? '',
            $trx->payment_status?? '',
            $trx->amount ?? '',
            $trx->trx_proof ?? '',
            $trx->paid_at ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            'No. Referensi',
            'No. Referensi Partner',
            'Nama Peserta',
            'No. Telepon',
            'Status Pembayaran',
            'Nominal',
            'Bukti Pembayaran',
            'Tanggal Pembayaran',
        ];
    }
    public function styles($sheet)
    {
        return [
            1 => ['font' => [
                'bold' => true,
                'size' => 14]],
        ];
    }
}
