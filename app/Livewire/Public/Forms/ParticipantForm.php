<?php

namespace App\Livewire\Public\Forms;

use App\Mail\HandsOnRegistrationMail;
use App\Models\FormParticipant;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Milon\Barcode\DNS2D;

class ParticipantForm extends Component
{
    public $email, $full_name, $no_telepon, $origin;
    public function create()
    {
        $uuid = Str::orderedUuid();
        $qr = new DNS2D();
        $qr = base64_decode($qr->getBarcodePNG(route('forms.detail', $uuid), 'QRCODE'));
        $path = 'img/forms/participant/' . $uuid . '.png';
        Storage::disk('public')->put($path, $qr);
        $participant = FormParticipant::create([
            'formId' => $uuid,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->no_telepon,
            'origin' => $this->origin,
            'barcode' => $path,
        ]);
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Registrasi berhasil!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        Mail::to($this->email)->send(new HandsOnRegistrationMail($participant));
        return $this->redirectRoute('participant_form');
    }
    #[Layout('components.layouts.public')]
    #[Title('Participant Registration')]
    public function render()
    {
        return view('livewire.public.forms.participant-form');
    }
}
