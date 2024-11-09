<?php

namespace App\Livewire\Forms;

use App\Models\Form;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class FormEdit extends Component
{
    use AuthorizesRequests;
    public $form, $formId, $name_str, $full_name, $email, $nik, $npa, $cabang_pdgi, $phone_number, $attended, $amount;
    public function mount($formId)
    {
        if(!Auth::user()->hasRole(['Super Admin','Admin','Finance'])) {
            abort(403, 'Unauthorized');
        }
        $this->form = Form::where('formId', $formId)->first();
        $this->name_str = $this->form->name_str;
        $this->full_name = $this->form->full_name;
        $this->email = $this->form->email;
        $this->nik = $this->form->nik;
        $this->npa = $this->form->npa;
        $this->cabang_pdgi = $this->form->cabang_pdgi;
        $this->phone_number = $this->form->phone_number;
        $this->attended = $this->form->attended;
        $this->amount = $this->form->amount;
    }
    public function update()
    {
        Form::where('formId', $this->formId)->update([
            'name_str' => $this->name_str,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'nik' => $this->nik,
            'npa' => $this->npa,
            'cabang_pdgi' => $this->cabang_pdgi,
            'phone_number' => $this->phone_number,
            'attended' => $this->attended,
            'amount' => $this->amount
        ]);
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Form successfully updated!',
            'toast'=> true,
            'position'=> 'top-end',
            'timer'=> 3000,
            'progbar' => true,
            'showConfirmButton'=> false
        ]);
        return $this->redirectRoute('forms.index', navigate:true);
    }
    #[Title('Edit Forms')]
    public function render()
    {
        return view('livewire.forms.form-edit', [
            'forms' => $this->form,
        ]);
    }
}
