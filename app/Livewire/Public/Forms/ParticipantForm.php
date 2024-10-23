<?php

namespace App\Livewire\Public\Forms;

use App\Models\FormParticipant;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class ParticipantForm extends Component
{
    public $email, $full_name, $no_telepon, $origin;
    public function create()
    {
        FormParticipant::create([
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->no_telepon,
            'origin' => $this->origin
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
        return $this->redirectRoute('participant_form', navigate:true);
    }
    #[Layout('components.layouts.public')]
    #[Title('Participant Registration')]
    public function render()
    {
        return view('livewire.public.forms.participant-form');
    }
}
