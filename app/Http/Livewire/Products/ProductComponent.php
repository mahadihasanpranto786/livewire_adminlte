<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductComponent extends Component
{

    use WithFileUploads;
    public $form = [];
    public $image;

    protected $listeners = ['delete' => 'delete'];
    //delete Data
    public function showDeleteConfirmation($userId)
    {
        $this->emit('showDeleteConfirmation', $userId);
    }
    public function delete($userId)
    {
        Product::find($userId)->delete();
    }


    public function render()
    {
        $data['productList'] = Product::where("status", 1)->paginate(10);
        return view('livewire.products.product-component', $data)
            ->extends('backend.master_layout')
            ->section('main');;
    }
}
