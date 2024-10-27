<?php

namespace App\Livewire\Public\Forms;

use App\Models\Form;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class FormDetail extends Component
{
    public $forms, $formId;

    public function mount($formId)
    {
        $this->forms = Form::where('formId', $formId)->first();
    }
    #[Layout('components.layouts.public')]
    #[Title('Detail Peserta')]
    public function render()
    {
        return view('livewire.public.forms.form-detail',[
            'form' => $this->forms,
        ]);
    }
}
