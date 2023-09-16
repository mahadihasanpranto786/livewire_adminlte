<div>
    <div class="col-md-12">
        <div class="card p-3">
            <div class="card-header">
                <div class="card-title">
                    <h2> Product List</h2>
                </div>
                <form action="{{route("products")}}" method="post" class="float-right">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search product name">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Purchase Price</th>
                            <th scope="col">Selling Price</th>
                            <th scope="col">Offer Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @forelse ($productList as $product)
                            <tr>
                                <th scope="row">{{ $sl++ }}</th>
                                <td><img src="{{ Storage::disk('public')->url('uploads/products/' . $product->image) }}"
                                        class="img-fluid rounded-circle" style="height:80px; width:80px;"
                                        alt=""></td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->purchase_price }}</td>
                                <td>{{ $product->selling_price }}</td>
                                <td>{{ $product->offer_price }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->created_at }}</td>
                                <td>
                                    <a class="btn   btn-primary btn-xs  "
                                        href="{{ route('edit_product', ['id' => $product->id]) }}"><i
                                            class="fa fa-edit"></i> Edit</a>

                                    <a class="btn btn-danger btn-xs  "
                                        wire:click.prevent='showDeleteConfirmation({{ $product->id }})'
                                        data-toggle="modal"><i class="fa fa-trash"></i> Delete</a>

                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>

                </table>
            </div>
            {{ $productList->links() }}
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function() {
                Livewire.on('showDeleteConfirmation', function(userId) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#2c9b10",
                        cancelButtonColor: "#e42061",
                        confirmButtonText: "Yes, delete it!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Perform the deletion using Livewire's wire method
                            Livewire.emit('delete', userId); // This line is redundant, remove it
                            Swal.fire("Deleted", "Data Deleted Successfully", "success");
                        }
                    });
                });
            });
        </script>
    @endpush
</div>
