<?php

namespace App\Imports;

use App\Models\FormParticipant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Milon\Barcode\DNS2D;

HeadingRowFormatter::default('none');

class ParticipantImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Pameran' => new ParticipantsImport()
        ];
    }
}

class ParticipantsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $uuid = Str::orderedUuid();
        $qr = new DNS2D();
        $qr = base64_decode($qr->getBarcodePNG(route('forms.participant.detail', $uuid), 'QRCODE'));
        $path = 'img/forms/participant/' . $uuid . '.png';
        Storage::disk('public')->put($path, $qr);

        FormParticipant::create([
            'formId' => $uuid,
            'full_name' => $row['Nama'],
            'email' => $row['Email'],
            'phone' => $row['Telepon'],
            'origin' => $row['Asal'],
            'barcode' => $path
        ]);
    }
}
