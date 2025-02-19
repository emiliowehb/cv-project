<?php

namespace App\Livewire\Professor;

use App\Models\ProfessorPresentation;
use App\Models\Country;
use App\Models\IntellectualContribution;
use App\Enums\MonthEnum;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddPresentationModal extends Component
{
    public $name;
    public $year;
    public $month;
    public $days;
    public $event_name;
    public $country_id;
    public $town;
    public $is_published_in_proceedings;
    public $intellectual_contribution_id;
    public $professor_id;
    public $edit_mode = false;
    public $presentation_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'name' => 'required|string|max:255',
            'year' => 'required|integer',
            'month' => 'required|string',
            'days' => 'nullable|string',
            'event_name' => 'nullable|string|max:255',
            'country_id' => 'required',
            'town' => 'nullable|string|max:255',
            'is_published_in_proceedings' => 'required|boolean',
            'intellectual_contribution_id' => 'required'
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->is_published_in_proceedings = false;
        $this->year = date('Y');
        $this->country_id = Country::first()?->id;
        $this->intellectual_contribution_id = IntellectualContribution::first()?->id;
        $months = MonthEnum::values();
        $this->month = !empty($months) ? $months[0] : null;
    }

    protected $listeners = [
        'update_presentation' => 'updatePresentation',
        'delete_presentation' => 'deletePresentation',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $countries = Country::all();
        $intellectualContributions = IntellectualContribution::all();
        $months = MonthEnum::hash();

        return view('livewire.professors.add-presentation-modal',
            compact('countries', 'intellectualContributions', 'months')
        );
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $data = [
                'professor_id' => $this->professor_id,
                'name' => $this->name,
                'year' => $this->year,
                'month' => $this->month,
                'days' => $this->days,
                'event_name' => $this->event_name,
                'country_id' => $this->country_id,
                'town' => $this->town,
                'is_published_in_proceedings' => $this->is_published_in_proceedings ? 1 : 0,
                'intellectual_contribution_id' => $this->intellectual_contribution_id,
            ];

            if ($this->edit_mode) {
                $presentation = ProfessorPresentation::findOrFail($this->presentation_to_edit);
                $presentation->update($data);
            } else {
                ProfessorPresentation::create($data);
            }
        });

        $this->hydrate();
        $this->dispatch('success', $this->edit_mode ? 'Presentation successfully updated.' : 'Presentation successfully added.');
    }

    public function deletePresentation($id)
    {
        $presentation = ProfessorPresentation::findOrFail($id);
        $presentation->delete();
        $this->dispatch('success', 'This presentation has been successfully deleted.');
    }

    public function updatePresentation($id)
    {
        $this->edit_mode = true;
        $this->presentation_to_edit = $id;
        $presentation = ProfessorPresentation::findOrFail($id);
        $this->name = $presentation->name;
        $this->year = $presentation->year;
        $this->month = $presentation->month;
        $this->days = $presentation->days;
        $this->event_name = $presentation->event_name;
        $this->country_id = $presentation->country_id;
        $this->town = $presentation->town;
        $this->is_published_in_proceedings = (bool) $presentation->is_published_in_proceedings;
        $this->intellectual_contribution_id = $presentation->intellectual_contribution_id;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset([
            'name', 'year', 'month', 'days', 'event_name', 'country_id',
            'town', 'is_published_in_proceedings', 'intellectual_contribution_id',
            'edit_mode', 'presentation_to_edit'
        ]);
        $this->mount();
    }
}
