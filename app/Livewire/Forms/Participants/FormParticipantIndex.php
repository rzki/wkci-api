<?php

namespace App\Livewire\Forms\Participants;

use App\Exports\HandsOnFormExport;
use App\Exports\ParticipantExport;
use App\Mail\HandsOnRegistrationMail;
use App\Mail\ParticipantFormMail;
use App\Models\Form;
use App\Models\FormParticipant;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class FormParticipantIndex extends Component
{
    use WithPagination;
    public $perPage = 5;
    public $form, $formId;
    public $search, $start_date = '', $end_date = '', $selectedItems = [];
    protected $listeners = ['deleteConfirmed' => 'delete'];

    public function deleteSelected()
    {
        // Delete the selected items
        FormParticipant::whereIn('id', $this->selectedItems)->delete();
        // Reset selected items and reload the items
        $this->selectedItems = [];
        session()->flash('alert',  [
            'type' => 'success',
            'title' => 'Selected form participant entries deleted successfully!',
            'toast' => true,
            'position' => 'top-right',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('forms.participant.index', navigate: true);
    }
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

    public function export()
    {
        $filename = 'JADE_Participant_'.date('d-m-Y').'.xlsx';
        return Excel::download(new ParticipantExport($this->start_date, $this->end_date), $filename);
    }
    #[Layout('components.layouts.app')]
    #[Title('Form Participants')]
    public function render()
    {
        return view('livewire.forms.participants.form-index',[
            'forms' => FormParticipant::search($this->search)
                        ->when($this->start_date !== '' && $this->end_date !== '', function ($query) {
                            $query->WhereDate('submitted_date', '>=', $this->start_date)
                                ->WhereDate('submitted_date', '<=', $this->end_date);
                        })
                        ->orderByDesc('submitted_date')->paginate($this->perPage),
        ]);
    }
}
