<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;
    public $form = [];
    public $name;
    protected $listeners = ['delete' => 'delete'];
     //delete Data
     public function showDeleteConfirmation($userId)
     {
         $this->emit('showDeleteConfirmation', $userId);
     }
     public function delete($userId)
     {
         User::find($userId)->delete();
     }



    // store data
    public function store()
    {
        $validateData = Validator::make($this->form, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ])->validate();

        User::create($validateData);

        session()->flash('success', 'Data Store Successfully');
        $this->reset();
    }

    public $updateForm = [];
    //edit modal open
    public function editUser(User $users)
    {
        $this->dispatchBrowserEvent('modal', 'show');
        $this->updateForm['edit_name'] = $users->name;
        $this->updateForm['edit_email'] = $users->email;
        $this->updateForm['id'] = $users->id;
    }
    //update edit data
    public function updateUserData()
    {
        $validateDataUpdate = Validator::make($this->updateForm, [
            'edit_name' => 'required',
            'edit_email' => 'required|unique:users,email,' . $this->updateForm['id'],
            'edit_password' => 'confirmed',
        ])->validate();
        $user = User::find($this->updateForm['id']);
        $user->name = $validateDataUpdate['edit_name'];
        $user->email = $validateDataUpdate['edit_email'];
        // Update the password only if a new password is provided
        if (!empty($validateDataUpdate['edit_password'])) {
            $user->password = Hash::make($validateDataUpdate['edit_password']);
        }
        $user->save();
        session()->flash('success', 'Data Updated Successfully');
        $this->reset();
        $this->dispatchBrowserEvent('modal', 'hide');
    }
    public function getUsersProperty(Request $request)
    {
        return User::when($this->name, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $this->name . '%');
            })
            ->paginate(10);
    }
    public function render()
    {
        $data["userList"] = $this->users;
        return view('livewire.user-component', $data)
            ->extends('backend.master_layout')
            ->section('main');
    }

}
