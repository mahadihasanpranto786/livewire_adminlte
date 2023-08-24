<div>

    <div class="row mt-1">
        <div class="col-md-8">
            <div class="card p-3">
                <div class="card-header">
                    <div class="card-title">
                        <h2> User List</h2>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @forelse ($userList as $user)
                                <tr>
                                    <th scope="row">{{ $sl++ }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <a class="btn btn-danger btn-xs  "
                                            wire:click.prevent='showDeleteConfirmation({{ $user->id }})'
                                            data-toggle="modal">Delete</a>


                                        <button wire:click.prevent="editUser({{ $user->id }})" type="button"
                                            class="btn btn-xs btn-primary">
                                            Edit
                                        </button>

                                    </td>
                                </tr>

                            @empty
                            @endforelse
                        </tbody>

                    </table>
                </div>
                {{ $userList->links() }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Create User</h2>
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
                    <form wire:submit.prevent='store'>
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" wire:model.debounce.500ms="form.name"
                                class="form-control" placeholder="Enter user name">
                            @error('name')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email"wire:model.debounce.500ms="form.email"
                                class="form-control" placeholder="Enter user email">
                            @error('email')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" wire:model.debounce.500ms="form.password"
                                class="form-control" placeholder="Enter  password">
                            @error('password')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" wire:model.debounce.500ms="form.password_confirmation"
                                    class="form-control" placeholder="Enter confirm password">
                            @error('password_confirmation')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <div class="modal fade" id="exampleModalCenter" wire:ignore.self>
        <!-- Use wire:ignore.self to prevent Livewire from managing this modal -->
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="updateUserData">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" wire:model.defer="updateForm.edit_name"
                                    wire:ignore class="form-control" placeholder="Enter user name">
                            </div>
                            @error('edit_name')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email"  wire:model.defer="updateForm.edit_email"
                                    wire:ignore class="form-control" placeholder="Enter user email">
                            </div>
                            @error('edit_email')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password"
                                    wire:model.defer="updateForm.edit_password" wire:ignore class="form-control"
                                    placeholder="Enter password">
                            </div>
                            @error('edit_password')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password"
                                    wire:model.defer="updateForm.password_confirmation" wire:ignore
                                    class="form-control" placeholder="Enter confirm password">
                            </div>
                            <input type="hidden" id="id" wire:model.defer="updateForm.id">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    window.addEventListener('modal', evnet => {
        $('#exampleModalCenter').modal(evnet.detail);
    }, false);
</script>
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
