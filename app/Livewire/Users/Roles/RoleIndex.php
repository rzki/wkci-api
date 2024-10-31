<?php

namespace App\Livewire\Users\Roles;

use App\Models\Role;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class RoleIndex extends Component
{
    use WithPagination;
    public $roles, $roleId;
    public $search,
        $perPage = 5;
    public $listeners = ['deleteConfirmed' => 'delete'];
    public function deleteConfirm($roleId)
    {
        $this->roleId = $roleId;
        $this->dispatch('delete-confirmation');
    }
    public function delete()
    {
        $this->roles = Role::where('id', $this->roleId)->first();
        $this->roles->delete();

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Role berhasil dihapus!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('roles.index', navigate: true);
    }
    #[Title('All Roles')]
    public function render()
    {
        return view('livewire.users.roles.role-index',[
            'role' => Role::search($this->search)
                ->where('name', '!=', 'Super Admin')
                ->paginate($this->perPage)
        ]);
    }
}
