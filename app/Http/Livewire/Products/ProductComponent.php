<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $form = [];
    public $image;
    public $name;

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
    public function getProductsProperty(Request $request)
    {
        return Product::where("status", 1)
            ->when($this->name, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $this->name . '%');
            })
            ->paginate(10);
    }

    public function render()
    {
        $data["productList"] = $this->products;

        return view('livewire.products.product-component', $data)
            ->extends('backend.master_layout')
            ->section('main');;
    }
}
