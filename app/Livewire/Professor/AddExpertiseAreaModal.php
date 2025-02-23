<?php

namespace App\Livewire\Professor;

use App\Models\ExpertiseArea;
use App\Models\ProfessorExpertiseArea;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddExpertiseAreaModal extends Component
{
    public $expertise_area_id;
    public $professor_id;
    public $edit_mode = false;
    public $expertise_area_to_edit;

    protected $rules;

    protected function rules()
    {
        return [
            'expertise_area_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = ProfessorExpertiseArea::where('professor_id', $this->professor_id)
                        ->where('expertise_area_id', $value)
                        ->exists();
                    if ($exists) {
                        $fail(__('messages.expertise_area_already_added'));
                    }
                },
            ],
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->expertise_area_id = ExpertiseArea::first()->id;
    }

    protected $listeners = [
        'update_re' => 'updateExpertiseArea',
        'delete_re' => 'deleteExpertiseArea',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $expertiseAreas = ExpertiseArea::all();
        return view('livewire.professors.add-expertise-area-modal', compact('expertiseAreas'));
    }

    public function submit()
    {
        // Validate the form input data
        $this->validate();

        DB::transaction(function () {
            if ($this->edit_mode) {
                // Update the existing professor expertise area
                $expertiseArea = ProfessorExpertiseArea::findOrFail($this->expertise_area_to_edit);
                $expertiseArea->update([
                    'expertise_area_id' => $this->expertise_area_id,
                ]);
            } else {
                // Create a new professor expertise area
                ProfessorExpertiseArea::create([
                    'professor_id' => $this->professor_id,
                    'expertise_area_id' => $this->expertise_area_id,
                ]);
            }
        });

        // Reset the form fields after successful submission
        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Expertise area successfully updated.' : 'Expertise area successfully added.');
    }

    public function deleteExpertiseArea($id)
    {
        $expertiseArea = ProfessorExpertiseArea::findOrFail($id);

        $expertiseArea->delete();

        $this->dispatch('success', 'This expertise area has been successfully deleted.');
    }

    public function updateExpertiseArea($id)
    {
        $this->edit_mode = true;

        $this->expertise_area_to_edit = $id;
        $expertiseArea = ProfessorExpertiseArea::findOrFail($id);

        $this->expertise_area_id = $expertiseArea->expertise_area_id;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['expertise_area_id', 'edit_mode', 'expertise_area_to_edit']);
        $this->mount();
    }
}
