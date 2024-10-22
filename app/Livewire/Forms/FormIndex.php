<?php

namespace App\Livewire\Forms;

use App\Models\Form;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class FormIndex extends Component
{
    use WithPagination;
    public $perPage = 5;
    public $form, $formId;
    protected $listeners = ['deleteConfirmed' => 'delete'];

    public function deleteConfirm($formId)
    {
        $this->formId = $formId;
        $this->dispatch('delete-confirmation');
    }
    public function delete()
    {
        $this->form = Form::where('formId', $this->formId)->first();
        $this->form->delete();
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Form entry deleted successfully!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('forms.index', navigate: true);
    }
    #[Title('Forms')]
    public function render()
    {
        return view('livewire.forms.form-index',[
            'forms' => Form::orderByDesc('created_at')
                        ->paginate($this->perPage)
        ]);
    }
}
