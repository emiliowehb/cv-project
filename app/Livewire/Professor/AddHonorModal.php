<?php

namespace App\Livewire\Professor;

use App\Models\HonorType;
use App\Models\HonorOrganization;
use App\Models\ProfessorHonor;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddHonorModal extends Component
{
    public $name;
    public $honor_type_id;
    public $honor_organization_id;
    public $start_year;
    public $end_year;
    public $is_ongoing;
    public $notes;
    public $professor_id;
    public $edit_mode = false;
    public $honor_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'name' => 'required|string|max:255',
            'honor_type_id' => 'required',
            'honor_organization_id' => 'required',
            'start_year' => 'required|integer',
            'end_year' => 'nullable|integer',
            'is_ongoing' => 'required|boolean',
            'notes' => 'nullable|string|max:255',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->is_ongoing = 0;
        $this->start_year = date('Y');
        $this->honor_type_id = HonorType::first()->id;
        $this->honor_organization_id = HonorOrganization::first()->id;
    }

    protected $listeners = [
        'update_honor' => 'updateHonor',
        'delete_honor' => 'deleteHonor',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $honorTypes = HonorType::all();
        $honorOrganizations = HonorOrganization::all();

        return view('livewire.professors.add-honor-modal', compact('honorTypes', 'honorOrganizations'));
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $data = [
                'professor_id' => $this->professor_id,
                'name' => $this->name,
                'honor_type_id' => $this->honor_type_id,
                'honor_organization_id' => $this->honor_organization_id,
                'start_year' => $this->start_year,
                'end_year' => $this->end_year,
                'is_ongoing' => $this->is_ongoing ? 1 : 0,
                'notes' => $this->notes,
            ];

            if ($this->edit_mode) {
                $honor = ProfessorHonor::findOrFail($this->honor_to_edit);
                $honor->update($data);
            } else {
                ProfessorHonor::create($data);
            }
        });

        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Honor successfully updated.' : 'Honor successfully added.');
    }

    public function deleteHonor($id)
    {
        $honor = ProfessorHonor::findOrFail($id);
        $honor->delete();
        $this->dispatch('success', 'This honor has been successfully deleted.');
    }

    public function updateHonor($id)
    {
        $this->edit_mode = true;
        $this->honor_to_edit = $id;
        $honor = ProfessorHonor::findOrFail($id);
        $this->name = $honor->name;
        $this->honor_type_id = $honor->honor_type_id;
        $this->honor_organization_id = $honor->honor_organization_id;
        $this->start_year = $honor->start_year;
        $this->end_year = $honor->end_year;
        $this->is_ongoing = $honor->is_ongoing ? true : false;
        $this->notes = $honor->notes;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['name', 'honor_type_id', 'honor_organization_id', 'start_year', 'end_year', 'is_ongoing', 'notes', 'edit_mode', 'honor_to_edit']);
        $this->mount();
    }
}
