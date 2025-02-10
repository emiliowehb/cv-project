<?php

namespace App\Livewire\Professor;

use App\Models\TeachingInterest;
use App\Models\ProfessorTeachingInterest;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddTeachingInterestModal extends Component
{
    public $teaching_interest_id;
    public $is_current;
    public $professor_id;
    public $edit_mode = false;
    public $teaching_interest_to_edit;

    protected $rules;

    protected function rules()
    {
        return [
            'teaching_interest_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = ProfessorTeachingInterest::where('professor_id', $this->professor_id)
                        ->where('teaching_interest_id', $value)
                        ->exists();
                    if ($exists) {
                        $fail(__('messages.teaching_interest_already_added'));
                    }
                },
            ],
            'is_current' => 'required|boolean',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->teaching_interest_id = TeachingInterest::first()->id;
        $this->is_current = true;
    }

    protected $listeners = [
        'update_te' => 'updateTeachingInterest',
        'delete_te' => 'deleteTeachingInterest',
    ];

    public function render()
    {
        $teachingInterests = TeachingInterest::all();
        return view('livewire.professors.add-teaching-interest-modal', compact('teachingInterests'));
    }

    public function submit()
    {
        // Validate the form input data
        $this->validate();

        DB::transaction(function () {
            if ($this->edit_mode) {
                // Update the existing professor teaching interest
                $teachingInterest = ProfessorTeachingInterest::findOrFail($this->teaching_interest_to_edit);
                $teachingInterest->update([
                    'teaching_interest_id' => $this->teaching_interest_id,
                    'is_current' => $this->is_current,
                ]);
            } else {
                // Create a new professor teaching interest
                ProfessorTeachingInterest::create([
                    'professor_id' => $this->professor_id,
                    'teaching_interest_id' => $this->teaching_interest_id,
                    'is_current' => $this->is_current,
                ]);
            }
        });

        // Reset the form fields after successful submission
        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Teaching interest successfully updated.' : 'Teaching interest successfully added.');
    }

    public function deleteTeachingInterest($id)
    {
        $teachingInterest = ProfessorTeachingInterest::findOrFail($id);

        $teachingInterest->delete();

        $this->dispatch('success', 'This teaching interest has been successfully deleted.');
    }

    public function updateTeachingInterest($id)
    {
        $this->edit_mode = true;

        $this->teaching_interest_to_edit = $id;
        $teachingInterest = ProfessorTeachingInterest::findOrFail($id);

        $this->teaching_interest_id = $teachingInterest->teaching_interest_id;
        $this->is_current = $teachingInterest->is_current;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
