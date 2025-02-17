<?php

namespace App\Livewire\Professor;

use App\Models\InterviewType;
use App\Models\ProfessorInterview;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddInterviewModal extends Component
{
    public $name;
    public $type_id;
    public $source;
    public $notes;
    public $start_date;
    public $end_date;
    public $professor_id;
    public $edit_mode = false;
    public $interview_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'name' => 'required',
            'type_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->type_id = InterviewType::first()->id;
        $this->start_date = date('Y-m-d');
    }

    protected $messages = [
        'name.required' => 'The interview name is required.',
        'type_id.required' => 'The interview type is required.',
        'start_date.required' => 'The start date is required.',
        'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
    ];

    protected $listeners = [
        'update_interview' => 'updateInterview',
        'delete_interview' => 'deleteInterview',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $types = InterviewType::all();
        return view('livewire.professors.add-interview-modal', compact('types'));
    }

    public function submit()
    {
        // Validate the form input data
        $this->validate();

        DB::transaction(function () {
            if ($this->edit_mode) {
                // Update the existing professor interview
                $interview = ProfessorInterview::findOrFail($this->interview_to_edit);
                $interview->update([
                    'name' => $this->name,
                    'type_id' => $this->type_id,
                    'source' => $this->source,
                    'notes' => $this->notes,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                ]);
            } else {
                // Create a new professor interview
                ProfessorInterview::create([
                    'professor_id' => $this->professor_id,
                    'name' => $this->name,
                    'type_id' => $this->type_id,
                    'source' => $this->source,
                    'notes' => $this->notes,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                ]);
            }
        });

        // Reset the form fields after successful submission
        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Interview successfully updated.' : 'Interview successfully added.');
    }

    public function deleteInterview($id)
    {
        $interview = ProfessorInterview::findOrFail($id);

        $interview->delete();

        $this->dispatch('success', 'This interview has been successfully deleted.');
    }

    public function updateInterview($id)
    {
        $this->edit_mode = true;

        $this->interview_to_edit = $id;
        $interview = ProfessorInterview::findOrFail($id);

        $this->name = $interview->name;
        $this->type_id = $interview->type_id;
        $this->source = $interview->source;
        $this->notes = $interview->notes;
        $this->start_date = $interview->start_date;
        $this->end_date = $interview->end_date;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['name', 'type_id', 'source', 'notes', 'start_date', 'end_date', 'edit_mode', 'interview_to_edit']);
        $this->mount();
    }
}
