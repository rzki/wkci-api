<?php

namespace App\Livewire\Public\Forms;

use App\Models\Form;
use App\Models\FormParticipant;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ParticipantFormDetail extends Component
{

    public $participant, $formId;

    public function mount($formId)
    {
        $this->participant = FormParticipant::where('formId', $formId)->first();
    }
    #[Layout('components.layouts.public')]
    #[Title('Detail Peserta Pameran')]
    public function render()
    {
        return view('livewire.public.forms.participant-form-detail');
    }
}
