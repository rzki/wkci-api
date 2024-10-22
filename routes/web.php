<?php

use App\Livewire\Dashboard;
use App\Livewire\Forms\FormEdit;
use App\Livewire\Forms\FormImport;
use App\Livewire\Forms\FormIndex;
use App\Livewire\Products\ProductCreate;
use App\Livewire\Products\ProductEdit;
use App\Livewire\Products\ProductIndex;
use App\Livewire\Public\Forms\HandsOnForm;
use App\Livewire\Public\Forms\SeminarForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/register/hands-on', HandsOnForm::class)->name('hands-on_form');
Route::get('/register/seminar', SeminarForm::class)->name('seminar_form');
