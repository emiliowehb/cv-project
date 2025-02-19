<?php

namespace App\Livewire\Professor;

use App\Models\ProfessionalActivityService;
use App\Models\ProfessorActivity;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddActivityModal extends Component
{
    public $name;
    public $start_year;
    public $end_year;
    public $is_current;
    public $notes;
    public $professor_id;
    public $activity_service_id;
    public $edit_mode = false;
    public $activity_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'name' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'end_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'is_current' => 'required|boolean',
            'notes' => 'nullable|string|max:255',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->start_year = date('Y');
        $this->activity_service_id = ProfessionalActivityService::first()->id;
        $this->is_current = false;
    }

    protected $listeners = [
        'update_activity' => 'updateActivity',
        'delete_activity' => 'deleteActivity',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $activityServices = ProfessionalActivityService::all();
        return view('livewire.professors.add-activity-modal', compact('activityServices'));
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            if ($this->edit_mode) {
                $activity = ProfessorActivity::findOrFail($this->activity_to_edit);
                $activity->update([
                    'name' => $this->name,
                    'start_year' => $this->start_year,
                    'end_year' => $this->end_year,
                    'is_current' => $this->is_current,
                    'activity_service_id' => $this->activity_service_id,
                    'notes' => $this->notes,
                ]);
            } else {
                ProfessorActivity::create([
                    'professor_id' => $this->professor_id,
                    'name' => $this->name,
                    'start_year' => $this->start_year,
                    'end_year' => $this->end_year,
                    'is_current' => $this->is_current,
                    'activity_service_id' => $this->activity_service_id,
                    'notes' => $this->notes,
                ]);
            }
        });

        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Activity successfully updated.' : 'Activity successfully added.');
    }

    public function deleteActivity($id)
    {
        $activity = ProfessorActivity::findOrFail($id);
        $activity->delete();
        $this->dispatch('success', 'This activity has been successfully deleted.');
    }

    public function updateActivity($id)
    {
        $this->edit_mode = true;
        $this->activity_to_edit = $id;
        $activity = ProfessorActivity::findOrFail($id);
        $this->name = $activity->name;
        $this->start_year = $activity->start_year;
        $this->end_year = $activity->end_year;
        $this->is_current = $activity->is_current ? true : false;
        $this->activity_service_id = $activity->activity_service_id;
        $this->notes = $activity->notes;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['name', 'start_year', 'end_year', 'is_current', 'notes', 'edit_mode', 'activity_to_edit', 'activity_service_id']);
        $this->mount();
    }
}
