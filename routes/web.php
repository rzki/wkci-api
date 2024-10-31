<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Livewire\Dashboard;
use App\Livewire\Forms\FormEdit;
use App\Livewire\Forms\FormIndex;
use App\Livewire\Forms\FormImport;
use App\Livewire\Forms\Participants\FormParticipantImport;
use App\Livewire\Forms\Participants\FormParticipantIndex;
use App\Livewire\MyProfile;
use App\Livewire\Public\Forms\FormDetail;
use App\Livewire\Public\Forms\ParticipantFormDetail;
use App\Livewire\Transactions\TransactionIndex;
use App\Livewire\Users\Permissions\PermissionCreate;
use App\Livewire\Users\Permissions\PermissionEdit;
use App\Livewire\Users\Permissions\PermissionIndex;
use App\Livewire\Users\Roles\RoleCreate;
use App\Livewire\Users\Roles\RoleEdit;
use App\Livewire\Users\Roles\RoleIndex;
use App\Livewire\Users\UserCreate;
use App\Livewire\Users\UserEdit;
use App\Livewire\Users\UserIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Products\ProductEdit;
use App\Livewire\Products\ProductIndex;
use App\Livewire\Products\ProductCreate;
use App\Livewire\Public\Forms\HandsOnForm;
use App\Livewire\Public\Forms\ParticipantForm;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });
});
Route::get('/email-template', function(){
    return view('emails.hands-on-registration');
});
Route::get('forms/hands-on/detail/{formId}', FormDetail::class)->name('forms.hands-on.detail');
Route::get('forms/participant/detail/{formId}', ParticipantFormDetail::class)->name('forms.participant.detail');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('products', ProductIndex::class)->name('products.index');
    Route::get('products/create', ProductCreate::class)->name('products.create');
    Route::get('products/edit/{productId}', ProductEdit::class)->name('products.edit');
    Route::get('forms', FormIndex::class)->name('forms.index');
    Route::get('forms/edit/{formId}', FormEdit::class)->name('forms.edit');
    Route::get('forms/import', FormImport::class)->name('forms.import');
    Route::get('forms/participants', FormParticipantIndex::class)->name('forms.participant.index');
    Route::get('forms/participants/import', FormParticipantImport::class)->name('forms.participant.import');
    Route::get('users', UserIndex::class)->name('users.index');
    Route::get('users/create', UserCreate::class)->name('users.create');
    Route::get('users/edit/{userId}', UserEdit::class)->name('users.edit');
    Route::get('profile', MyProfile::class)->name('profile.show');
    Route::get('transactions', TransactionIndex::class)->name('transactions.index');
    Route::get('roles', RoleIndex::class)->name('roles.index');
    Route::get('roles/create', RoleCreate::class)->name('roles.create');
    Route::get('roles/edit/{roleId}', RoleEdit::class)->name('roles.edit');
});

Route::get('/register/hands-on', HandsOnForm::class)->name('hands-on_form');
Route::get('/register/participant', ParticipantForm::class)->name('participant_form');
