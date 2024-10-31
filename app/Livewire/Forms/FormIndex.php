<?php

namespace App\Livewire\Forms;

use App\Exports\HandsOnFormExport;
use App\Mail\HandsOnRegistrationMail;
use App\Models\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Maatwebsite\Excel\Facades\Excel;

class FormIndex extends Component
{
    use WithPagination;
    public $perPage = 5, $search;
    public $form, $formId, $start_date = '', $end_date = '';
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

    public function export()
    {
        $filename = 'JADE_HandsOnForm_'.date('d-m-Y').'.xlsx';
        return Excel::download(new HandsOnFormExport($this->start_date, $this->end_date), $filename);
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
