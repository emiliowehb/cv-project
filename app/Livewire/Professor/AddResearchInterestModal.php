<?php

namespace App\Livewire\Professor;

use App\Models\ResearchInterest;
use App\Models\ProfessorResearchInterest;
use App\Models\ResearchArea;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddResearchInterestModal extends Component
{
    public $research_area_id;
    public $professor_id;
    public $edit_mode = false;
    public $research_interest_to_edit;

    protected $rules;

    protected function rules()
    {
        return [
            'research_area_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = ProfessorResearchInterest::where('professor_id', $this->professor_id)
                        ->where('research_area_id', $value)
                        ->exists();
                    if ($exists) {
                        $fail(__('messages.research_interest_already_added'));
                    }
                },
            ],
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->research_area_id = ResearchArea::first()->id;
    }

    protected $listeners = [
        'update_re' => 'updateResearchInterest',
        'delete_re' => 'deleteResearchInterest',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $researchInterests = ResearchArea::all();
        return view('livewire.professors.add-research-interest-modal', compact('researchInterests'));
    }

    public function submit()
    {
        // Validate the form input data
        $this->validate();

        DB::transaction(function () {
            if ($this->edit_mode) {
                // Update the existing professor research interest
                $researchInterest = ProfessorResearchInterest::findOrFail($this->research_interest_to_edit);
                $researchInterest->update([
                    'research_area_id' => $this->research_area_id,
                ]);
            } else {
                // Create a new professor research interest
                ProfessorResearchInterest::create([
                    'professor_id' => $this->professor_id,
                    'research_area_id' => $this->research_area_id,
                ]);
            }
        });

        // Reset the form fields after successful submission
        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Research interest successfully updated.' : 'Research interest successfully added.');
    }

    public function deleteResearchInterest($id)
    {
        $researchInterest = ProfessorResearchInterest::findOrFail($id);

        $researchInterest->delete();

        $this->dispatch('success', 'This research interest has been successfully deleted.');
    }

    public function updateResearchInterest($id)
    {
        $this->edit_mode = true;

        $this->research_interest_to_edit = $id;
        $researchInterest = ProfessorResearchInterest::findOrFail($id);

        $this->research_area_id = $researchInterest->research_area_id;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['research_area_id', 'edit_mode', 'research_interest_to_edit']);
        $this->mount();
    }
}
