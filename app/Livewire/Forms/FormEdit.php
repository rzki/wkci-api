<?php

namespace App\Livewire\Forms;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class FormEdit extends Component
{
    use AuthorizesRequests;
    public function mount()
    {
        if(!Auth::user()->hasRole(['Super Admin','Admin','Finance'])) {
            abort(403, 'Unauthorized');
        }
    }
    #[Title('Edit Forms')]
    public function render()
    {
        return view('livewire.forms.form-edit');
    }
}
