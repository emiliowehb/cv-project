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


    // Professor personal info section (Step 1)
    public $user_id;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $email;
    public $office_email;
    public $website;
    public $country_id;
    public $birth_date;
    public $gender;

    // Professor address section (step 2)
    public $country_of_residence;
    public $address_line_1;
    public $address_line_2;
    public $city;
    public $state;
    public $postcode;

    // Professor language section (step 3)
    public $languageData = [
        ['language' => '', 'spoken' => '', 'written' => '']
    ];



    protected $listeners = ['updatedCountry', 'updateBirthDate'];

    public function mount()
    {
        $user = Auth::user();
        $this->user_id = $user->id;
        $this->first_name = $user->first_name;
        $this->middle_name = '';
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->office_email = $user->office_email;
        $this->country_id = '';
        $this->birth_date = '';
        $this->website = $user->website;
        $this->gender = 1;

        $this->country_of_residence = '';
        $this->address_line_1 = '';
        $this->address_line_2 = '';
        $this->city = '';
        $this->state = '';
        $this->postcode = '';

        $this->languageData = [
            ['language' => '', 'spoken' => '', 'written' => '']
        ];
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
        $genders = [
            ['id' => '1', 'label' => 'Male'],
            ['id' => '2', 'label' => 'Female'],
        ];

        return view('livewire.faculty-members.add-personal-info-modal', compact('countries', 'languages', 'levels', 'genders'));
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
                    'birth_date' => $this->birth_date,
                    'office_email' => $this->office_email,
                    'website' => $this->website,
                    'country_id' => $this->country_id,
                    'gender' => $this->gender,

                    'country_of_residence' => $this->country_of_residence,
                    'address_line_1' => $this->address_line_1,
                    'address_line_2' => $this->address_line_2,
                    'city' => $this->city,
                    'state' => $this->state,
                    'postcode' => $this->postcode,

                    'languages_spoken' => $this->languageData,

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

    public function updateBirthDate($date)
    {
        $this->birth_date = $date;
    }

    public function addLanguage()
    {
        $this->languageData[] = ['language' => '', 'spoken' => '', 'written' => ''];
    }
    
    public function removeLanguage($index)
    {
        unset($this->languageData[$index]);
        $this->languageData = array_values($this->languageData); // Reset array keys
    }
}
