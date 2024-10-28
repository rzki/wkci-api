<?php

namespace App\Livewire\Users;

use App\Mail\UserRegistrationMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

class UserCreate extends Component
{
    public $name, $email;
    public function create()
    {
        $users = User::create([
            'userId' => Str::orderedUuid(),
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make('Jade2024!')
        ]);
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
        return view('livewire.users.user-create');
    }
}
