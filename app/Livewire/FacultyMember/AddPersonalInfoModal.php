<?php

namespace App\Livewire\FacultyMember;

use App\Models\Country;
use App\Models\Language;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AddPersonalInfoModal extends Component
{
    use WithFileUploads;

    public $user_id;
    public $name;
    public $email;
    public $role;
    public $avatar;
    public $saved_avatar;

    public $edit_mode = false;

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'role' => 'required|string',
        'avatar' => 'nullable|sometimes|image|max:1024',
    ];

    protected $listeners = [
        'delete_user' => 'deleteUser',
        'update_user' => 'updateUser',
        'new_user' => 'hydrate',
    ];

    public function render()
    {
        $countries = Country::all();
        $languages = Language::all();
        $levels = [
            ['id' => '0', 'name' => 'Beginner'],
            ['id' => '1', 'name' => 'Working Knowledge'],
            ['id' => '2', 'name' => 'Intermediate'],
            ['id' => '3', 'name' => 'Fluent'],
            ['id' => '5', 'name' => 'N/A'],
        ];

        return view('livewire.faculty-members.add-personal-info-modal', compact('countries', 'languages', 'levels'));
    }

    public function submit()
    {
        // Validate the form input data
        $this->validate();

        DB::transaction(function () {
            // Prepare the data for creating a new user
            $data = [
                'name' => $this->name,
            ];

            if ($this->avatar) {
                $data['profile_photo_path'] = $this->avatar->store('avatars', 'public');
            } else {
                $data['profile_photo_path'] = null;
            }

            if (!$this->edit_mode) {
                $data['password'] = Hash::make($this->email);
            }

            // Update or Create a new user record in the database
            $data['email'] = $this->email;
            $user = User::find($this->user_id) ?? User::create($data);

            if ($this->edit_mode) {
                foreach ($data as $k => $v) {
                    $user->$k = $v;
                }
                $user->save();
            }

            if ($this->edit_mode) {
                // Assign selected role for user
                $user->syncRoles($this->role);

                // Emit a success event with a message
                $this->dispatch('success', __('User updated'));
            } else {
                // Assign selected role for user
                $user->assignRole($this->role);

                // Send a password reset link to the user's email
                // Password::sendResetLink($user->only('email'));

                // Emit a success event with a message
                $this->dispatch('success', __('New user created'));
            }
        });

        // Reset the form fields after successful submission
        $this->reset();
    }

    public function deleteUser($id)
    {
        // Prevent deletion of current user
        if ($id == Auth::id()) {
            $this->dispatch('error', 'User cannot be deleted');
            return;
        }

        // Delete the user record with the specified ID
        User::destroy($id);

        // Emit a success event with a message
        $this->dispatch('success', 'User successfully deleted');
    }

    public function updateUser($id)
    {
        $this->edit_mode = true;

        $user = User::find($id);

        $this->user_id = $user->id;
        $this->saved_avatar = $user->profile_photo_url;
        $this->name = $user->first_name . ' ' . $user->last_name;
        $this->email = $user->email;
        $this->role = $user->roles?->first()->name ?? '';
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
