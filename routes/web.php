<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Livewire\Dashboard;
use App\Livewire\Forms\FormEdit;
use App\Livewire\Forms\FormIndex;
use App\Livewire\Forms\FormImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Products\ProductEdit;
use App\Livewire\Products\ProductIndex;
use App\Livewire\Products\ProductCreate;
use App\Livewire\Public\Forms\HandsOnForm;
use App\Livewire\Public\Forms\ParticipantForm;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('products', ProductIndex::class)->name('products.index');
    Route::get('products/create', ProductCreate::class)->name('products.create');
    Route::get('products/edit/{productId}', ProductEdit::class)->name('products.edit');
    Route::get('forms', FormIndex::class)->name('forms.index');
    Route::get('forms/{formId}', FormEdit::class)->name('forms.edit');
    Route::get('forms/import', FormImport::class)->name('forms.import');
    Route::get('forms/participant', FormIndex::class)->name('forms.index');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/register/hands-on', HandsOnForm::class)->name('hands-on_form');
Route::get('/register/participant', ParticipantForm::class)->name('participant_form');
