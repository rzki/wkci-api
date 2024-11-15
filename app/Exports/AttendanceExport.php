<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
        return Attendance::query()
            ->when($this->start_date, function ($query) {
                $query->whereDate('created', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                $query->whereDate('created', '<=', $this->end_date);
            })->get();
    }

    public function map($attendance): array
    {
        return [
            $attendance->name ?? '',
            $attendance->participant_type ?? '',
            $attendance->attendance_time ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Peserta',
            'Tipe Peserta',
            'Tanggal & Jam Hadir',
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
