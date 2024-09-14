<?php

use App\Http\Controllers\DashboardController;
use App\Livewire\UserComponent;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/user_component', UserComponent::class)->name('user_component');

});
