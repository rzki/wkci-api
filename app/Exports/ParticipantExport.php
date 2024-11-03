<?php

namespace App\Exports;

use App\Models\Form;
use App\Models\FormParticipant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class ParticipantExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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

        return FormParticipant::query()
            ->when($this->start_date, function ($query) {
                $query->whereDate('submitted_date', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                $query->whereDate('submitted_date', '<=', $this->end_date);
            })->get();
    }
    public function map($participant): array
    {
        return [
            $participant->full_name ?? '',
            $participant->email ?? '',
            $participant->phone ?? '',
            $participant->origin ?? '',
        ];
    }
    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Email',
            'Nomor Telepon',
            'Asal Institusi/Perusahaan/Klinik'
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
