<?php

namespace App\Livewire\Public\Forms;

use App\Mail\HandsOnRegistrationMail;
use App\Mail\ParticipantFormMail;
use App\Models\FormParticipant;
use Carbon\Carbon;
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
        $qr = base64_decode($qr->getBarcodePNG(route('forms.participant.detail', $uuid), 'QRCODE'));
        $path = 'img/forms/participant/' . $uuid . '.png';
        Storage::disk('public')->put($path, $qr);
        $participant = FormParticipant::create([
            'formId' => $uuid,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->no_telepon,
            'origin' => $this->origin,
            'barcode' => $path,
            'submitted_date' => Carbon::now()
        ]);
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Registrasi berhasil!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 1500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        Mail::to($this->email)->send(new ParticipantFormMail($participant));
        return $this->redirectRoute('forms.participant.detail', $uuid);
    }
    #[Layout('components.layouts.public')]
    #[Title('Participant Registration')]
    public function render()
    {
        return view('livewire.public.forms.participant-form');
    }
}
