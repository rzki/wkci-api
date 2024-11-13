<?php

namespace App\Livewire\Forms\Participants;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\FormParticipant;

class FormParticipantEdit extends Component
{
    public $participants, $participantId, $full_name, $email, $phone, $origin;

    public function mount($participantId)
    {
        $this->participants = FormParticipant::where('formId', $participantId)->first();
        $this->full_name = $this->participants->full_name;
        $this->email = $this->participants->email;
        $this->phone = $this->participants->phone;
        $this->origin = $this->participants->origin;
    }
    public function update()
    {
        FormParticipant::where('formId', $this->participantId)->update([
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'origin' => $this->origin
        ]);
        return $this->redirectRoute('forms.participant.index', navigate:true);
    }
    #[Title('Edit Participant Data')]
    public function render()
    {
        return view('livewire.forms.participants.form-participant-edit');
    }
}
