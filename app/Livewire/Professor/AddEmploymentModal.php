<?php

namespace App\Livewire\Professor;

use App\Models\Country;
use App\Models\Position;
use App\Models\Employment;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddEmploymentModal extends Component
{
    public $employer;
    public $country_id;
    public $position_id;
    public $start_year;
    public $end_year;
    public $is_current = false;
    public $is_full_time = false;
    public $professor_id;
    public $edit_mode = false;
    public $employment_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'employer' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'position_id' => 'required|exists:positions,id',
            'start_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'end_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'is_current' => 'boolean',
            'is_full_time' => 'boolean',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
    }

    protected $listeners = [
        'update_employment' => 'updateEmployment',
        'delete_employment' => 'deleteEmployment',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $countries = Country::all();
        $positions = Position::all();
        return view('livewire.professors.add-employment-modal', compact('countries', 'positions'));
    }

    public function submit()
    {
        // Validate the form input data
        $this->validate();

        DB::transaction(function () {
            if ($this->edit_mode) {
                // Update the existing employment
                $employment = Employment::findOrFail($this->employment_to_edit);
                $employment->update([
                    'employer' => $this->employer,
                    'country_id' => $this->country_id,
                    'position_id' => $this->position_id,
                    'start_year' => $this->start_year,
                    'end_year' => $this->end_year,
                    'is_current' => $this->is_current ? 1 : 0,
                    'is_full_time' => $this->is_full_time ? 1 : 0,
                ]);
            } else {
                // Create a new employment
                Employment::create([
                    'professor_id' => $this->professor_id,
                    'employer' => $this->employer,
                    'country_id' => $this->country_id,
                    'position_id' => $this->position_id,
                    'start_year' => $this->start_year,
                    'end_year' => $this->end_year,
                    'is_current' => $this->is_current ? 1 : 0,
                    'is_full_time' => $this->is_full_time ? 1 : 0,
                ]);
            }
        });

        // Reset the form fields after successful submission
        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Employment successfully updated.' : 'Employment successfully added.');
    }

    public function deleteEmployment($id)
    {
        $employment = Employment::findOrFail($id);

        $employment->delete();

        $this->dispatch('success', 'This employment has been successfully deleted.');
    }

    public function updateEmployment($id)
    {
        $this->edit_mode = true;

        $this->employment_to_edit = $id;
        $employment = Employment::findOrFail($id);

        $this->employer = $employment->employer;
        $this->country_id = $employment->country_id;
        $this->position_id = $employment->position_id;
        $this->start_year = $employment->start_year;
        $this->end_year = $employment->end_year;
        $this->is_current = $employment->is_current ? true : false;
        $this->is_full_time = $employment->is_full_time ? true : false;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['employer', 'country_id', 'position_id', 'start_year', 'end_year', 'is_current', 'is_full_time', 'edit_mode', 'employment_to_edit']);
        $this->mount();
    }
}
