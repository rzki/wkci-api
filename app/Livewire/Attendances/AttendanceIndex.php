<?php

namespace App\Livewire\Attendances;

use Livewire\Component;
use App\Models\Attendance;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class AttendanceIndex extends Component
{
    use WithPagination;
    public $perPage = 5, $search;
    public $attendances, $start_date = '', $end_date = '';
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
