
<?php

namespace App\Http\Livewire\FacultyMembers;

use Livewire\Component;

class AddPersonalInfoModal extends Component
{
    public $currentStep = 1;
    public $first_name, $middle_name, $last_name, $date_of_birth, $country_of_birth, $email, $office_email, $website;
    public $country_of_residence, $address_line_1, $address_line_2, $town, $state, $postcode;
    public $languages = [];

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
        'country_of_birth' => 'required|integer',
        'office_email' => 'required|email|unique:users,office_email',
        'website' => 'nullable|url',
        'country_of_residence' => 'required|integer',
        'address_line_1' => 'required|string|max:255',
        'address_line_2' => 'nullable|string|max:255',
        'town' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'postcode' => 'required|string|max:20',
        'languages.*.language' => 'required|integer',
        'languages.*.spoken_level' => 'required|integer',
        'languages.*.written' => 'required|integer',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    private function validateStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'country_of_birth' => 'required|integer',
                'email' => 'required|email',
                'office_email' => 'required|email',
                'website' => 'nullable|url',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'country_of_residence' => 'required|integer',
                'address_line_1' => 'required|string|max:255',
                'address_line_2' => 'nullable|string|max:255',
                'town' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'postcode' => 'required|string|max:20',
            ]);
        } elseif ($this->currentStep == 3) {
            $this->validate([
                'languages.*.language' => 'required|integer',
                'languages.*.spoken_level' => 'required|integer',
                'languages.*.written' => 'required|integer',
            ]);
        }
    }

    public function submit()
    {
        $this->validate();

        // ...submit logic...
    }

    public function render()
    {
        return view('livewire.faculty-members.add-personal-info-modal');
    }
}