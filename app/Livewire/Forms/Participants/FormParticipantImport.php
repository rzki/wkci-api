<?php

namespace App\Livewire\Forms\Participants;

use App\Imports\FormsImport;
use App\Imports\ParticipantImport;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class FormParticipantImport extends Component
{
    use WithFileUploads;
    public $forms;
    public function import()
    {
        // Store file to temp folder
        $originalPath = $this->forms->store('file-temp');
        $newPath = storage_path('app').'/'.$originalPath;
        // Execute stored temp file
        Excel::import(new ParticipantImport(), $newPath);
        // delete temp file
        Storage::disk('local')->delete($newPath);

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Form entries imported successfully!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('forms.participant.index', navigate: true);
    }
    #[Title('Import Data Form')]
    public function render()
    {
        return view('livewire.forms.participants.form-participant-import');
    }
}
