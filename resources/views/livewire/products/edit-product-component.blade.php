<div>
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Edit Product</h2>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form wire:submit.prevent='update_product' enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" wire:model.debounce.500ms="form.name" class="form-control"
                                        placeholder="Enter name">
                                    @error('name')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="purchase_price">Purchase Price</label>
                                    <input type="text" wire:model.debounce.500ms="form.purchase_price"
                                        class="form-control" placeholder="Enter purchase price">
                                    @error('purchase_price')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="selling_price">Selling Price</label>
                                    <input type="text" wire:model.debounce.500ms="form.selling_price"
                                        class="form-control" placeholder="Enter selling price">
                                    @error('selling_price')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="offer_price">Offer Price</label>
                                    <input type="text" wire:model.debounce.500ms="form.offer_price"
                                        class="form-control" placeholder="Enter offer price">
                                    @error('offer_price')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" wire:model="form.image" class="form-control">
                                    <div wire:loading wire:target='form.image' wire:key='form.image'><i
                                            class="fa fa-spinner fa-spin"></i>Uploading</div>
                                    @error('image')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                    @if ($image)
                                        <img class="mt-2" src="{{ $image->temporaryUrl() }}" height="100"
                                            width="100">
                                    @else
                                    <img class="mt-2" src="{{ URL::asset('storage/uploads/products/'.$product->image) ?? '' }}" height="100"
                                    width="100">
                                     @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="text" wire:model.debounce.500ms="form.quantity" class="form-control"
                                        placeholder="Enter quantity">
                                    @error('quantity')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="editor1" type="text" wire:model.debounce.500ms="form.description" class="form-control"
                                placeholder="Enter description"></textarea>
                            @error('description')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit">
                            <div wire:loading wire:target='store_product' wire:key='store_product'><i
                                    class="fa fa-spinner fa-spin"></i></div>
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
