<?php

namespace App\Livewire\Forms\Participants;

use App\Mail\HandsOnRegistrationMail;
use App\Mail\ParticipantFormMail;
use App\Models\Form;
use App\Models\FormParticipant;
use Illuminate\Support\Facades\Mail;
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
        return $this->redirectRoute('forms.participant.index', navigate: true);
    }
    public function sendEmail($formId)
    {
        $this->formId = $formId;
        $participant = FormParticipant::where('formId', $formId)->first();
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Email sent!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        Mail::to($participant->email)->send(new ParticipantFormMail($participant));
        return $this->redirectRoute('forms.participant.index', navigate: true);
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
