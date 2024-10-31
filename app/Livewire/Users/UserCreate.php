<?php

namespace App\Livewire\Users;

use App\Mail\UserRegistrationMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

class UserCreate extends Component
{
    use AuthorizesRequests;
    public $name, $email, $role;
    public function mount()
    {
        if(!Auth::user()->hasRole(['Super Admin', 'Admin'])){
            abort(403, 'Unauthorized');
        }
    }
    public function create()
    {
        $users = User::create([
            'userId' => Str::orderedUuid(),
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make('Jade2024!')
        ]);
        $users->assignRole($this->role);
        session()->flash('alert', [
            'type' => 'success',
            'title' => 'User Registration Successful!',
            'toast' => true,
            'position' => 'top-end',
            'timer' => 2500,
            'progbar' => true,
            'showConfirmButton' => false,
        ]);
        Mail::to($this->email)->send(new UserRegistrationMail($users));
        return $this->redirectRoute('users.index', navigate:true);
    }
    #[Title('Create New User')]
    public function render()
    {
        return view('livewire.users.user-create',[
            'roles' => Role::where('name', '!=', 'Super Admin')->get()
        ]);
    }
}
