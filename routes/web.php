<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\UserComponent;
use App\Http\Livewire\Products\ProductComponent;
use App\Http\Livewire\Products\CreateProductComponent;
use App\Http\Livewire\Products\EditProductComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/create', [DashboardController::class, 'create'])->name('create');
Route::get('/user_component', UserComponent::class)->name('user_component');
Route::get('/create_product', CreateProductComponent::class)->name('create_product');
Route::get('/store_product', CreateProductComponent::class)->name('store_product');
Route::get('/products', ProductComponent::class)->name('products');
Route::get('/edit_product/{id}', EditProductComponent::class)->name('edit_product');


Route::post('/ck_image_upload', [CommonController::class, 'ckImageUpload'])->name("ck_image_upload");
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
