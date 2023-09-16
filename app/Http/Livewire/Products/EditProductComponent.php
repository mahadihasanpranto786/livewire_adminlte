<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class EditProductComponent extends Component
{
    use WithFileUploads;

    public $productId;
    public $product;
    public $form = [];
    public $image;
    public $oldImageFilename;

    //set data to form
    public function mount($id)
    {
        $this->productId = $id;
        $this->product = Product::find($id);
        $this->form = $this->product->toArray();
        $this->oldImageFilename = $this->product->image;
    }
    // live check data
    function updated()
    {
        if ($this->form['image']) {
            $this->image = $this->form['image'];
        }
    }
    public function update_product()
    {
        $validatedData = Validator::make($this->form, [
            'name' => ['required', 'string', 'max:255'],
            'purchase_price' => ['required', 'max:11'],
            'selling_price' => ['required', 'max:11'],
            'offer_price' => ['required', 'max:11'],
            'quantity' => ['required', 'numeric'],
            'description' => ['required']
        ])->validate();
        // Check if a new image is uploaded
        if ($this->image) {
            $filename = $this->form['image']->getClientOriginalName();
            $this->form['image']->storeAs('products', $filename, 'public');
            $validatedData["image"] = $filename; 
        } else {
            $validatedData["image"] =  $this->oldImageFilename;
        }

        $validatedData["status"] = 1;

        $this->product->update($validatedData);

        session()->flash('success', 'Data Updated Successfully');
    }

    public function render()
    {
        return view('livewire.products.edit-product-component')
            ->extends('backend.master_layout')
            ->section('main');
    }
}
