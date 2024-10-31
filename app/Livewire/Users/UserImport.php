<?php

namespace App\Livewire\Users;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserImport extends Component
{
    use AuthorizesRequests;
    public function mount()
    {
        if(!Auth::user()->hasRole(['Super Admin', 'Admin'])){
            abort(403, 'Unauthorized');
        }
    }
    public function render()
    {
        return view('livewire.users.user-import');
    }
}
