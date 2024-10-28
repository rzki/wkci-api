<?php

namespace App\Livewire\Forms\Participants;

use App\Models\FormParticipant;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class FormParticipantIndex extends Component
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
        $this->form = FormParticipant::where('formId', $this->formId)->first();
        $this->form->delete();
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Participant form entry deleted successfully!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('forms.index', navigate: true);
    }
    #[Layout('components.layouts.app')]
    #[Title('Form Participants')]
    public function render()
    {
        return view('livewire.forms.participants.form-index',[
            'forms' => FormParticipant::orderByDesc('created_at')->paginate($this->perPage),
        ]);
    }
}
