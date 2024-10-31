<?php

namespace App\Exports;

use App\Models\Form;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class HandsOnFormExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
        return Form::query()
            ->when($this->start_date, function ($query) {
                $query->whereDate('submitted_date', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                $query->whereDate('submitted_date', '<=', $this->end_date);
            })->get();
    }

    public function map($handsOn): array
    {
        return [
            $handsOn->name_str ?? '',
            $handsOn->full_name ?? '',
            $handsOn->email ?? '',
            $handsOn->nik ?? '',
            $handsOn->npa ?? '',
            $handsOn->cabang_pdgi ?? '',
            $handsOn->phone_number ?? '',
            $handsOn->seminar ?? '',
            $handsOn->attended ?? '',
            $handsOn->amount ?? '',
            $handsOn->trx_history ?? '',
            $handsOn->submitted_date ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            'Nama (STR)',
            'Nama Lengkap (KTP)',
            'Email',
            'NIK',
            'NPA',
            'Cabang PDGI',
            'No. Telepon',
            'Seminar',
            'Hands On',
            'Total Pembayaran',
            'Bukti Pembayaran',
            'Tanggal Submit'
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
