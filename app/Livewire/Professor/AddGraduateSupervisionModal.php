<?php

namespace App\Livewire\Professor;

use App\Enums\MonthEnum;
use App\Models\ProfessorGraduateSupervision;
use App\Models\StudyProgram;
use App\Models\SupervisionStatus;
use App\Models\SupervisionRole;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddGraduateSupervisionModal extends Component
{
    public $student_first_name;
    public $student_last_name;
    public $professor_id;
    public $start_year;
    public $start_month;
    public $end_year;
    public $end_month;
    public $student_program_area;
    public $student_program_name;
    public $study_program_id;
    public $supervision_status_id;
    public $supervision_role_id;
    public $student_type;
    public $edit_mode = false;
    public $supervision_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'student_first_name' => 'required|string|max:255',
            'student_last_name' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:' . date('Y'),
            'start_month' => 'required',
            'end_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'end_month' => 'nullable',
            'student_program_area' => 'required|string|max:255',
            'student_program_name' => 'required|string|max:255',
            'study_program_id' => 'required',
            'supervision_status_id' => 'required',
            'supervision_role_id' => 'required',
            'student_type' => 'required|in:undergraduate,graduate,doctoral',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->start_year = date('Y');
        $this->start_month = MonthEnum::values()[0];
        $this->study_program_id = StudyProgram::first()->id;
        $this->supervision_status_id = SupervisionStatus::first()->id;
        $this->supervision_role_id = SupervisionRole::first()->id;
        $this->student_type = 'graduate';
    }

    protected $listeners = [
        'update_supervision' => 'updateSupervision',
        'delete_supervision' => 'deleteSupervision',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $studyPrograms = StudyProgram::all();
        $supervisionStatuses = SupervisionStatus::all();
        $supervisionRoles = SupervisionRole::all();
        $months = MonthEnum::hash();

        return view('livewire.professors.add-graduate-supervision-modal', compact('studyPrograms', 'supervisionStatuses', 'supervisionRoles', 'months'));
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $data = [
                'student_first_name' => $this->student_first_name,
                'student_last_name' => $this->student_last_name,
                'professor_id' => $this->professor_id,
                'start_year' => $this->start_year,
                'start_month' => $this->start_month,
                'end_year' => $this->end_year,
                'end_month' => $this->end_month,
                'student_program_area' => $this->student_program_area,
                'student_program_name' => $this->student_program_name,
                'study_program_id' => $this->study_program_id,
                'supervision_status_id' => $this->supervision_status_id,
                'supervision_role_id' => $this->supervision_role_id,
                'is_undergraduate' => $this->student_type === 'undergraduate',
                'is_graduate' => $this->student_type === 'graduate',
                'is_doctoral' => $this->student_type === 'doctoral',
            ];

            if ($this->edit_mode) {
                $supervision = ProfessorGraduateSupervision::findOrFail($this->supervision_to_edit);
                $supervision->update($data);
            } else {
                ProfessorGraduateSupervision::create($data);
            }
        });

        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Supervision successfully updated.' : 'Supervision successfully added.');
    }

    public function deleteSupervision($id)
    {
        $supervision = ProfessorGraduateSupervision::findOrFail($id);
        $supervision->delete();
        $this->dispatch('success', 'This supervision has been successfully deleted.');
    }

    public function updateSupervision($id)
    {
        $this->edit_mode = true;
        $this->supervision_to_edit = $id;
        $supervision = ProfessorGraduateSupervision::findOrFail($id);
        $this->student_first_name = $supervision->student_first_name;
        $this->student_last_name = $supervision->student_last_name;
        $this->start_year = $supervision->start_year;
        $this->start_month = $supervision->start_month;
        $this->end_year = $supervision->end_year;
        $this->end_month = $supervision->end_month;
        $this->student_program_area = $supervision->student_program_area;
        $this->student_program_name = $supervision->student_program_name;
        $this->study_program_id = $supervision->study_program_id;
        $this->supervision_status_id = $supervision->supervision_status_id;
        $this->supervision_role_id = $supervision->supervision_role_id;
        $this->student_type = $supervision->is_undergraduate ? 'undergraduate' : ($supervision->is_graduate ? 'graduate' : 'doctoral');
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['student_first_name', 'student_last_name', 'start_year', 'start_month', 'end_year', 'end_month', 'student_program_area', 'student_program_name', 'study_program_id', 'supervision_status_id', 'supervision_role_id', 'student_type', 'edit_mode', 'supervision_to_edit']);
        $this->mount();
    }
}
