<div>
    <div class="row mt-1">
        <div class="col-md-8">
            <div class="card p-3 card-outline card-primary">
                <div class="card-header">
                    <div class="card-title">
                        <h2> User List</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('user_component') }}" method="post" class="mt-0">
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model="name" placeholder="Search user name">
                        </div>
                    </form>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
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
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <button   type="button"
                                            class="btn btn-xs btn-primary"  wire:click="editUser({{ $user->id }})">
                                         <i class="fa fa-edit"></i>   Edit
                                        </button>
                                        <a class="btn btn-danger btn-xs  "
                                        wire:click="delete({{ $user->id }})"
                                       wire:confirm="Are you sure you want to delete this post?"
                                             ><i class="fa fa-trash"></i> Delete</a>

                                    </td>
                                </tr>

                            @empty
                            @endforelse
                        </tbody>

                    </table>
                </div>
                {{ $userList->links("pagination::bootstrap-5") }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="card  card-outline card-primary">
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
                            <label for="phone">Phone</label>
                            <input type="phone"wire:model.debounce.500ms="form.phone"
                                class="form-control" placeholder="Enter user phone">
                            @error('phone')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" wire:model.debounce.500ms="form.password"
                                class="form-control" placeholder="Enter  password">
                            {{-- @error('password')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror --}}
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
    <div class="modal" id="exampleModalCenter" wire:ignore.self>
        <!-- Use wire:ignore.self to prevent Livewire from managing this modal -->
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header card-outline card-primary">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card  ">
                    <div class="card-body">
                        <form wire:submit.prevent="update">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" wire:model.defer="updateForm.edit_name" class="form-control" placeholder="Enter user name">
                            </div>
                            @error('updateForm.edit_name')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" wire:model.defer="updateForm.edit_email" class="form-control" placeholder="Enter user email">
                            </div>
                            @error('updateForm.edit_email')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="phone" wire:model.defer="updateForm.edit_phone" class="form-control" placeholder="Enter user phone">
                            </div>
                            @error('updateForm.edit_phone')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" wire:model.defer="updateForm.password" class="form-control" placeholder="Enter password">
                            </div>
                            @error('password')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" wire:model.defer="updateForm.password_confirmation" class="form-control" placeholder="Enter confirm password">
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
  window.addEventListener('modal', event => {
    if (event.detail == 'show') {
        $('#exampleModalCenter').modal('show');
    } else if (event.detail == 'hide') {
        $('#exampleModalCenter').modal('hide');
    }
}, false);
</script>
