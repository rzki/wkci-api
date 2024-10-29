<?php

namespace App\Livewire\Forms;

use App\Mail\HandsOnRegistrationMail;
use App\Models\Form;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class FormIndex extends Component
{
    use WithPagination;
    public $perPage = 5, $search;
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
    public function sendEmail($formId)
    {
        $this->formId = $formId;
        $handsOn = Form::where('formId', $formId)->first();
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Email sent!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        Mail::to($handsOn->email)->send(new HandsOnRegistrationMail($handsOn));
        return $this->redirectRoute('forms.index', navigate: true);
    }
    #[Title('Forms')]
    public function render()
    {
        return view('livewire.forms.form-index',[
            'forms' => Form::search($this->search)->orderByDesc('id')
                        ->paginate($this->perPage)
        ]);
    }
}
