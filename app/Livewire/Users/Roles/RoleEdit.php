<?php

namespace App\Livewire\Users\Roles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RoleEdit extends Component
{
    use AuthorizesRequests;

    public function mount()
    {
        if(!Auth::user()->hasRole(['Super Admin'])){
            abort(403, 'Unauthorized');
        }
    }
    public function render()
    {
        return view('livewire.users.roles.role-edit');
    }
}
