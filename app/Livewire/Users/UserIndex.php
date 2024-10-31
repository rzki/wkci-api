<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

class UserIndex extends Component
{
    use WithPagination;
    public $perPage = 5;
    public $user, $userId;
    public $listeners = ['deleteConfirmed' => 'delete'];

    public function deleteConfirm($userId)
    {
        $this->userId = $userId;
        $this->dispatch('delete-confirmation');
    }
    public function delete()
    {
        $this->user = User::where('userId', $this->userId)->first();
        $this->user->delete();
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'User deleted successfully!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('users.index', navigate: true);
    }
    public function resetPassword($userId)
    {
        $this->userId = $userId;
        $this->user = User::where('userId', $this->userId)->update([
            'password' => Hash::make('Jade2024!')
        ]);

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Password reset successfully!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        return $this->redirectRoute('users.index', navigate:true);
    }
    #[Title('All Users')]
    public function render()
    {
        return view('livewire.users.user-index',[
            'users' => User::with('roles')->orderByDesc('created_at')->paginate($this->perPage)
        ]);
    }
}
