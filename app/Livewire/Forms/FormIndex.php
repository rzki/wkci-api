<?php

namespace App\Livewire\Forms;

use App\Models\Form;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Exports\HandsOnFormExport;
use App\Jobs\SendPaidBulkEmailJob;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\HandsOnRegistrationMail;
use App\Mail\SeminarParticipantEmail;
use Illuminate\Support\Facades\Storage;

class FormIndex extends Component
{
    use WithPagination;
    public $perPage = 5, $search;
    public $form, $formId, $start_date = '', $end_date = '';
    public $formCollection, $selectedItems = [], $selectedRecipient = [];
    protected $listeners = ['deleteConfirmed' => 'delete'];
    public function deleteSelected()
    {
        // Get selected items data
        $itemsToDelete = Form::whereIn('id', $this->selectedItems)->get();
        foreach ($itemsToDelete as $item)
        {
            Storage::disk('public')->delete($item->barcode);
        }
        // Delete the selected items
        Form::whereIn('id', $this->selectedItems)->delete();
        // Reset selected items and reload the items
        $this->selectedItems = [];
        session()->flash('alert',  [
            'type' => 'success',
            'title' => 'Selected form entries deleted successfully!',
            'toast' => true,
            'position' => 'top-right',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('forms.index', navigate: true);
    }
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
        if($handsOn->status == 'Paid'){
            Mail::to($handsOn->email)->send(new SeminarParticipantEmail($handsOn));
        }else{
            Mail::to($handsOn->email)->send(new HandsOnRegistrationMail($handsOn));
        }
        return $this->redirectRoute('forms.index', navigate: true);
    }
    public function export()
    {
        $filename = 'JADE_HandsOnForm_'.date('d-m-Y').'.xlsx';
        return Excel::download(new HandsOnFormExport($this->start_date, $this->end_date), $filename);
    }
    public function bulkSendEmail()
    {
        $formPaid = Form::whereIn('id', $this->selectedItems)->where('status', 'Paid')->get();
        foreach($formPaid as $paid){
            SendPaidBulkEmailJob::dispatch($paid);
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

    #[Title('Forms')]
    public function render()
    {
        return view('livewire.forms.form-index',[
            'forms' => Form::search($this->search)
                        ->when($this->start_date !== '' && $this->end_date !== '', function ($query) {
                            $query->WhereDate('submitted_date', '>=', $this->start_date)
                            ->WhereDate('submitted_date', '<=', $this->end_date);
                        })
                        ->orderByDesc('submitted_date')
                        ->paginate($this->perPage)
        ]);
    }
}
