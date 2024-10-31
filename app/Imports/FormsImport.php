<?php

namespace App\Imports;

use App\Models\Form;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Milon\Barcode\DNS2D;
use PhpOffice\PhpSpreadsheet\Shared\Date;

HeadingRowFormatter::default('none');
class FormsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Peserta_JADE' => new DataFormImport(),
        ];
    }
}

class DataFormImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $uuid = Str::orderedUuid();
        $qr = new DNS2D();
        $qr = base64_decode($qr->getBarcodePNG(route('forms.hands-on.detail', $uuid), 'QRCODE'));
        $path = 'img/forms/hands-on/' . $uuid . '.png';
        $timestampDate = Carbon::instance(Date::excelToDateTimeObject($row['Timestamp']));
        $submitDate = $timestampDate->toDateTimeString();
        $date = Carbon::instance(Date::excelToDateTimeObject($row['TANGGAL']));
        $dateFormat = $date->toDateString();
        $time = Carbon::instance(Date::excelToDateTimeObject($row['WAKTU']));
        $timeFormat = $time->toTimeString();
        Storage::disk('public')->put($path, $qr);

        Form::create([
            'formId' => $uuid,
            'name_str' => $row['name_str'],
            'full_name' => $row['full_name'],
            'email' => $row['email'],
            'nik' => $row['nik'],
            'npa' => $row['npa'],
            'cabang_pdgi' => $row['cabang_pdgi'],
            'phone_number' => $row['phone_number'],
            'attended' => $row['attended'],
            'amount' => $row['amount'] ?? '0,00',
            'trx_history' => $row['Bukti Transfer'],
            'barcode' => $path,
            'submitted_date' => $submitDate ?? '',
        ]);
        Transaction::create([
            'transactionId' => Str::orderedUuid(),
            'participant_name' => $row['full_name'],
            'payment_status' => 'Paid',
            'amount' => $row['amount'] ?? '',
            'paid_at' => $dateFormat.' '.$timeFormat ?? '',
            'trx_proof' => $row['Bukti Transfer'],
            'submitted_date' => $submitDate ?? '',
        ]);
    }
}


