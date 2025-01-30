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
    public $first_name;
    public $middle_name;
    public $last_name;
    public $email;
    public $office_email;
    public $website;
    public $role;
    public $avatar;
    public $saved_avatar;

    public function mount()
    {
        $user = Auth::user();
        $this->user_id = $user->id;
        $this->first_name = $user->first_name;
        $this->middle_name = $user->middle_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->office_email = $user->office_email;
        $this->website = $user->website;
        // Initialize other properties as needed
    }

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
        try {

            DB::transaction(function () {
                // Prepare the data for creating a new user
                $data = [
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'last_name' => $this->last_name,
                    'email' => $this->email,
                    'office_email' => $this->office_email,
                    'website' => $this->website,
                ];
                return dd($data);

                if ($this->avatar) {
                    $data['profile_photo_path'] = $this->avatar->store('avatars', 'public');
                } else {
                    $data['profile_photo_path'] = null;
                }

                // Update or Create a new user record in the database
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

                // Reset the form fields after successful submission
                $this->reset();
            });
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
