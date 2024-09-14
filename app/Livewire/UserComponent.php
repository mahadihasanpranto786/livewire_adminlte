<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class UserComponent extends Component
{
    public $users;
    public $form = [];
    public $perPage = 10;
    public ?User $user;

    public function store()
    {
        $validateData = Validator::make($this->form, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string',  'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ])->validate();
        User::create($validateData);
        session()->flash('success', 'Data Store Successfully');
        $this->reset();
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
    public $updateForm = [];
    public function editUser(User $users)
    {
        $this->dispatch('modal', 'show');
        $this->updateForm['edit_name'] = $users->name;
        $this->updateForm['edit_email'] = $users->email;
        $this->updateForm['edit_phone'] = $users->phone;
        $this->updateForm['id'] = $users->id;
    }

    public function update()
    {

        $validator = Validator::make($this->updateForm, [
            'edit_name' => 'required',
            'edit_email' => 'required|email|unique:users,email,' . $this->updateForm['id'],
            'edit_phone' => 'required|unique:users,phone,' . $this->updateForm['id'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);
 
        // Validate and handle errors
        $validator->validate();
        $user = User::findOrFail($this->updateForm['id']);
        $user->name = $this->updateForm['edit_name'];
        $user->email = $this->updateForm['edit_email'];
        $user->phone = $this->updateForm['edit_phone'];
        if (!empty($this->updateForm['password'])) {
            $user->password = Hash::make($this->updateForm['password']);
        }
        $user->save();
        $this->dispatch('modal', 'hide');
        session()->flash('success', 'User updated successfully!');
        $this->reset('updateForm');
    }



    public function render()
    {
        $data['userList'] = User::paginate($this->perPage);
        return view('livewire.user-component', $data)
            ->extends('backend.master_pages.master_layout')
            ->section('main');
    }
}
