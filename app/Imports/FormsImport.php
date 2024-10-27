<?php

namespace App\Imports;

use App\Models\Form;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Milon\Barcode\DNS2D;

class FormsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Peserta_JADE' => new DataFormImport(),
        ];
    }
}

HeadingRowFormatter::default('none');
class DataFormImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $uuid = Str::orderedUuid();
        $qr = new DNS2D();
        $qr = base64_decode($qr->getBarcodePNG(route('forms.detail', $uuid), 'QRCODE'));
        $path = 'img/forms/' . $uuid . '.png';
        Storage::disk('public')->put($path, $qr);

        $form = Form::create([
            'formId' => $uuid,
            'name_str' => $row['name_str'],
            'full_name' => $row['full_name'],
            'email' => $row['email'],
            'nik' => $row['nik'],
            'npa' => $row['npa'],
            'cabang_pdgi' => $row['cabang_pdgi'],
            'phone_number' => $row['phone_number'],
            'attended' => $row['attended'],
            'amount' => $row['amount'],
            'barcode' => $path,
        ]);
        Log::info($form);
//        dd($form);
//        return $form;
    }
}


