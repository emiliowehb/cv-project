<?php

namespace App\Livewire\Professor;

use App\Models\Department;
use App\Models\IntellectualContribution;
use App\Models\ProfessorWorkingPaper;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddWorkingPaperModal extends Component
{
    public $year;
    public $identifying_number;
    public $name;
    public $notes;
    public $department_id;
    public $intellectual_contribution_id;
    public $professor_id;
    public $edit_mode = false;
    public $paper_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'identifying_number' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'department_id' => 'required',
            'intellectual_contribution_id' => 'required',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->year = date('Y');
        $this->department_id = Department::first()->id;
        $this->intellectual_contribution_id = IntellectualContribution::first()->id;
    }

    protected $listeners = [
        'update_paper' => 'updatePaper',
        'delete_paper' => 'deletePaper',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $departments = Department::all();
        $intellectualContributions = IntellectualContribution::all();
        return view('livewire.professors.add-working-paper-modal', compact('departments', 'intellectualContributions'));
    }

    public function submit()
    {
        $this->validate();
        DB::transaction(function () {
            if ($this->edit_mode) {
                $paper = ProfessorWorkingPaper::findOrFail($this->paper_to_edit);
                $paper->update([
                    'year' => $this->year,
                    'identifying_number' => $this->identifying_number,
                    'name' => $this->name,
                    'notes' => $this->notes,
                    'department_id' => $this->department_id,
                    'intellectual_contribution_id' => $this->intellectual_contribution_id,
                ]);
            } else {
                ProfessorWorkingPaper::create([
                    'professor_id' => $this->professor_id,
                    'year' => $this->year,
                    'identifying_number' => $this->identifying_number,
                    'name' => $this->name,
                    'notes' => $this->notes,
                    'department_id' => $this->department_id,
                    'intellectual_contribution_id' => $this->intellectual_contribution_id,
                ]);
            }
        });

        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Working paper successfully updated.' : 'Working paper successfully added.');
    }

    public function deletePaper($id)
    {
        $paper = ProfessorWorkingPaper::findOrFail($id);
        $paper->delete();
        $this->dispatch('success', 'This working paper has been successfully deleted.');
    }

    public function updatePaper($id)
    {
        $this->edit_mode = true;
        $this->paper_to_edit = $id;
        $paper = ProfessorWorkingPaper::findOrFail($id);
        $this->year = $paper->year;
        $this->identifying_number = $paper->identifying_number;
        $this->name = $paper->name;
        $this->notes = $paper->notes;
        $this->department_id = $paper->department_id;
        $this->intellectual_contribution_id = $paper->intellectual_contribution_id;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['year', 'identifying_number', 'name', 'notes', 'department_id', 'intellectual_contribution_id', 'edit_mode', 'paper_to_edit']);
        $this->mount();
    }
}
