<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Title;
use Livewire\Component;

class FormEdit extends Component
{
    #[Title('Edit Forms')]
    public function render()
    {
        return view('livewire.forms.form-edit');
    }
}
