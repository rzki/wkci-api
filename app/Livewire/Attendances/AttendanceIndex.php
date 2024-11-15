<?php

namespace App\Livewire\Attendances;

use App\Exports\AttendanceExport;
use Livewire\Component;
use App\Models\Attendance;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceIndex extends Component
{
    use WithPagination;
    public $perPage = 5, $search;
    public $attendances, $attendanceId, $start_date = '', $end_date = '';
    protected $listeners = ['deleteConfirmed' => 'delete'];
    public function deleteConfirm($attendanceId)
    {
        $this->attendanceId = $attendanceId;
        $this->dispatch('delete-confirmation');
    }
    public function delete()
    {
        $attendances = Attendance::where('attendanceId', $this->attendanceId)->first();
        $attendances->delete();
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Attendance entry deleted successfully!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 1500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('attendances.index', navigate: true);
    }
    public function export()
    {
        $filename = 'JADE_Attendance_'.date('d-m-Y').'.xlsx';
        return Excel::download(new AttendanceExport($this->start_date, $this->end_date), $filename);
    }

    #[Title('Attendance')]
    public function render()
    {
        return view('livewire.attendances.attendance-index',[
            'attendance' => Attendance::search($this->search)
                        ->when($this->start_date !== '' && $this->end_date !== '', function ($query) {
                            $query->WhereDate('created_at', '>=', $this->start_date)
                                ->WhereDate('created_at', '<=', $this->end_date);
                        })
                        ->orderByDesc('created_at')->paginate($this->perPage)
        ]);
    }
}
