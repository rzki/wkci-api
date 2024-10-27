<?php

namespace App\Livewire\Public\Forms;

use App\Mail\HandsOnRegistrationMail;
use App\Models\Form;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Milon\Barcode\DNS2D;

class HandsOnForm extends Component
{
    public $name_str, $name_ktp, $nik, $npa, $email, $pdgi_cabang, $no_telepon;
    public $isHandsOnChecked = [], $selectedSeminarId, $totalAmount = 0, $handsOn, $seminars;

    public function mount()
    {
        $this->handsOn = Product::where('type', 'Hands-On')->get();
        $this->seminars = Product::where('type', 'Seminar')->get();
    }

    public function updatedSelectedSeminars()
    {
        $this->calculateTotalAmount();
    }

    public function updatedIsHandsOnSelected()
    {
        $this->calculateTotalAmount();
    }

    public function calculateTotalAmount()
    {
        // Reset the total amount before recalculating
        $this->totalAmount = 0;

        // Calculate total for selected seminars
        if ($this->selectedSeminarId) {
            $selectedSeminar = $this->seminars->find($this->selectedSeminarId);
            if ($selectedSeminar) {
                $this->totalAmount += $selectedSeminar->price;
            }
        }

        // Calculate total for selected hands-on options
        foreach ($this->isHandsOnChecked as $optionId => $isSelected) {
            if ($isSelected) {
                $selectedHandsOnOption = $this->handsOn->find($optionId);
                if ($selectedHandsOnOption) {
                    $this->totalAmount += $selectedHandsOnOption->price;
                }
            }
        }
    }

    public function submit(Request $request)
    {
        $seminar = $this->seminars->find($this->selectedSeminarId);
        foreach ($this->isHandsOnChecked as $optionId => $isSelected) {
            if ($isSelected) {
                // Find the corresponding hands-on option by ID
                $selectedOption = $this->handsOn->firstWhere('id', $optionId);
                if ($selectedOption) {
                    $selectedOptionCodes[] = $selectedOption->code;
                }
            }
        }
        $code = implode(', ', $selectedOptionCodes) ?? '';
        $uuid = Str::orderedUuid();
        $qr = new DNS2D();
        $qr = base64_decode($qr->getBarcodePNG(route('forms.hands-on.detail', $uuid), 'QRCODE'));
        $path = 'img/forms/hands-on/' . $uuid . '.png';
        Storage::disk('public')->put($path, $qr);
        $handsOn = Form::create([
            'formId' => $uuid,
            'name_str' => $this->name_str,
            'full_name' => $this->name_ktp,
            'email' => $this->email,
            'nik' => $this->nik,
            'npa' => $this->npa,
            'cabang_pdgi' => $this->pdgi_cabang,
            'phone_number' => $this->no_telepon,
            'seminar_type' => $seminar->name ?? '',
            'attended' => $code,
            'amount' => $this->totalAmount,
            'barcode' => $path,
        ]);
        Mail::to($this->email)->send(new HandsOnRegistrationMail($handsOn));
        return $this->redirectRoute('generate_qr', ['amount' => $this->totalAmount]);
    }
    #[Layout('components.layouts.public')]
    #[Title('Hands-On Registration')]
    public function render()
    {
        return view('livewire.public.forms.hands-on-form');
    }
}
