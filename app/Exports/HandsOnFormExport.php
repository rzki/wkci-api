<?php

namespace App\Exports;

use App\Models\Form;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class HandsOnFormExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithCustomValueBinder
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
            $handsOn->attended ?? '',
            $handsOn->amount ?? '',
            $handsOn->trx_history ?? '',
            $handsOn->submitted_date ?? '',
            $handsOn->paid_at ?? '',
            $handsOn->applied_coupon ?? '',
            $handsOn->status ?? ''
        ];
    }
    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT,
        ];
    }
    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
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
            'Seminar & Hands On',
            'Total Pembayaran',
            'Bukti Pembayaran',
            'Tanggal Submit',
            'Tanggal Pembayaran',
            'Kode Promo',
            'Status Pembayaran'
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
