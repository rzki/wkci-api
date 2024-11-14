<?php

namespace App\Livewire\Forms\Participants;

use App\Models\Form;
use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;
use App\Models\FormParticipant;
use Livewire\Attributes\Layout;
use App\Mail\ParticipantFormMail;
use App\Exports\HandsOnFormExport;
use App\Exports\ParticipantExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\HandsOnRegistrationMail;
use App\Jobs\SendBulkEmailParticipant;

class FormParticipantIndex extends Component
{
    use WithPagination;
    public $perPage = 5;
    public $form, $formId;
    public $search, $start_date = '', $end_date = '', $selectAll = false, $selectedItems = [];
    protected $listeners = ['deleteConfirmed' => 'delete'];

    public function updatedSelectAll($value)
    {
        if($value)
        {
            $this->selectedItems = FormParticipant::orderByDesc('submitted_date')->paginate($this->perPage)->pluck('id')->map(fn($id) => (string) $id)->toArray();
        }else{
            $this->selectedItems = [];
        }
    }
    public function updatedSelectedItems()
    {
        // Get the IDs for the current page
        $currentPageIds = FormParticipant::orderByDesc('submitted_date')->paginate($this->perPage)->pluck('id')->map(fn($id) => (string) $id)->toArray();

        // Check if all items on the current page are selected
        $this->selectAll = !array_diff($currentPageIds, $this->selectedItems) ? true : false;
    }
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
    public function sendBulkEmail()
    {
        $participantData = FormParticipant::whereIn('id', $this->selectedItems)->get();
        foreach($participantData as $participant)
        {
            SendBulkEmailParticipant::dispatch($participant);
        }
        $this->selectedItems = [];
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Email confirmation sent!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
    }
    public function export()
    {
        $filename = 'JADE_Participant_'.date('d-m-Y').'.xlsx';
        return Excel::download(new ParticipantExport($this->start_date, $this->end_date), $filename);
    }

    public function attendanceCheck($formId)
    {
        $this->formId = $formId;
        $users = FormParticipant::where('formId', $formId)->first();

        Attendance::create([
            'attendanceId' => Str::orderedUuid(),
            'name' => $users->full_name,
            'participant_type' => 'Participant',
            'attendance_time' => Carbon::now()->timezone('Asia/Jakarta'),
            'handler' => Auth::user()->name
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Attendance checked!',
            'toast' => false,
            'position' => 'center',
            'timer' => 1500,
            // 'progbar' => true,
            // 'showConfirmButton' => false,
        ]);

        return $this->redirectRoute('forms.index', navigate:true);
    }
    #[Layout('components.layouts.app')]
    #[Title('Form Participants')]
    public function render()
    {
        $formParticipant = FormParticipant::search($this->search)
                        ->when($this->start_date !== '' && $this->end_date !== '', function ($query) {
                            $query->WhereDate('submitted_date', '>=', $this->start_date)
                                ->WhereDate('submitted_date', '<=', $this->end_date);
                        })
                        ->orderByDesc('submitted_date')->paginate($this->perPage);
        return view('livewire.forms.participants.form-index',[
            'forms' => $formParticipant,
        ]);
    }
}
