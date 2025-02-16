<?php

namespace App\Livewire\Professor;

use App\Models\Degree;
use App\Models\Department;
use App\Models\Discipline;
use App\Models\ProfessorDegree;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddEducationModal extends Component
{

    public $year;
    public $professor_id;
    public $degree_id;
    public $discipline_id;
    public $department_id;
    public $institution_name;
    public $edit_mode = false;
    public $degree_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'degree_id' => 'required',
            'institution_name' => 'required',
            'discipline_id' => 'required',
            'department_id' => 'required',
        ];
    }


    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->year = date('Y');
        $this->degree_id = Degree::first()->id;
        $this->institution_name = '';
        $this->discipline_id = Discipline::first()->id;
        $this->department_id = Department::first()->id;
    }

    protected $messages = [
        'email.unique' => 'The email address has already been invited to this workspace, or the email associated with this invite already exists in another workspace.',
    ];

    protected $listeners = [
        'update_degree' => 'updateDegree',
        'delete_degree' => 'deleteDegree',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $degrees = Degree::all();
        $disciplines = Discipline::all();
        $departments = Department::all();
        return view('livewire.professors.add-education-modal', compact('degrees', 'disciplines', 'departments'));
    }

    public function submit()
    {
        // Validate the form input data
        $this->validate();

        DB::transaction(function () {
            if ($this->edit_mode) {
                // Update the existing professor degree
                $degree = ProfessorDegree::findOrFail($this->degree_to_edit);
                $degree->update([
                    'degree_id' => $this->degree_id,
                    'discipline_id' => $this->discipline_id,
                    'institution_name' => $this->institution_name,
                    'department_id' => $this->department_id,
                    'year' => $this->year,
                ]);
            } else {
                // Create a new professor degree
                ProfessorDegree::create([
                    'professor_id' => $this->professor_id,
                    'degree_id' => $this->degree_id,
                    'institution_name' => $this->institution_name,
                    'discipline_id' => $this->discipline_id,
                    'department_id' => $this->department_id,
                    'year' => $this->year,
                ]);
            }
        });

        // Reset the form fields after successful submission
        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Degree successfully updated.' : 'Degree successfully added.');
    }

    public function deleteDegree($id)
    {
        $degree = ProfessorDegree::findOrFail($id);

        $degree->delete();

        $this->dispatch('success', 'This degree has been successfully deleted.');
    }

    public function updateDegree($id)
    {
        $this->edit_mode = true;

        $this->degree_to_edit = $id;
        $degree = ProfessorDegree::findOrFail($id);

        $this->degree_id = $degree->degree_id;
        $this->institution_name = $degree->institution_name;
        $this->discipline_id = $degree->discipline_id;
        $this->department_id = $degree->department_id;
        $this->year = $degree->year;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['year', 'degree_id', 'discipline_id', 'department_id', 'edit_mode', 'degree_to_edit', 'institution_name']);
        $this->mount();
    }
}
