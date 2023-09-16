<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class CreateProductComponent extends Component
{
    use WithFileUploads;
    public $form = [];
    public $image;


    public function __construct()
    {
        $this->form['image'] = null;
    }
    // store data
    function updated()
    {
        if ($this->form['image']) {
            $this->image = $this->form['image'];
        }
    }
    public function store_product()
    {
        $validatedData = Validator::make($this->form, [
            'name' => ['required', 'string', 'max:255'],
            'purchase_price' => ['required', 'max:11'],
            'selling_price' => ['required', 'max:11'],
            'offer_price' => ['required', 'max:11'],
            'quantity' => ['required', 'numeric'],
            'description' => ['required'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ])->validate();

        $this->image = $this->form['image'];
        $filename =  $this->form['image']->getClientOriginalName();
        $this->form['image']->storeAs('products', $filename, 'public');
        
        $validatedData["image"] = $filename;
        $validatedData["status"] = 1;

        Product::create($validatedData);
        session()->flash('success', 'Data Store Successfully');
        $this->reset();
    }

    public function render()
    {
        // $this->emit('providerUpdated');
        return view('livewire.products.create-product-component')
            ->extends('backend.master_layout')
            ->section('main');
    }
}
