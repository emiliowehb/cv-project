<?php

namespace App\Livewire\Professor;

use App\Models\Language;
use App\Models\Session;
use App\Models\Country;
use App\Models\ProfessorOutsideCourse;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddOutsideCourseModal extends Component
{
    public $name;
    public $institution;
    public $year;
    public $country_id;
    public $town;
    public $language_id;
    public $is_graduate;
    public $session_id;
    public $notes;
    public $professor_id;
    public $edit_mode = false;
    public $course_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'year' => 'required|integer',
            'country_id' => 'required',
            'town' => 'nullable|string|max:255',
            'language_id' => 'required',
            'is_graduate' => 'required|boolean',
            'session_id' => 'required',
            'notes' => 'nullable|string',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->is_graduate = 0;
        $this->language_id = Language::first()->id;
        $this->country_id = Country::first()->id;
        $this->session_id = Session::first()->id;
    }

    protected $listeners = [
        'update_course' => 'updateCourse',
        'delete_course' => 'deleteCourse',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $languages = Language::all();
        $countries = Country::all();
        $sessions = Session::all();

        return view('livewire.professors.add-outside-course-modal', compact('languages', 'countries', 'sessions'));
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $data = [
                'professor_id' => $this->professor_id,
                'name' => $this->name,
                'institution' => $this->institution,
                'year' => $this->year,
                'country_id' => $this->country_id,
                'town' => $this->town,
                'language_id' => $this->language_id,
                'is_graduate' => $this->is_graduate ? 1 : 0,
                'session_id' => $this->session_id,
                'notes' => $this->notes,
            ];

            if ($this->edit_mode) {
                $course = ProfessorOutsideCourse::findOrFail($this->course_to_edit);
                $course->update($data);
            } else {
                ProfessorOutsideCourse::create($data);
            }
        });

        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Outside course successfully updated.' : 'Outside course successfully added.');
    }

    public function deleteCourse($id)
    {
        $course = ProfessorOutsideCourse::findOrFail($id);
        $course->delete();
        $this->dispatch('success', 'This outside course has been successfully deleted.');
    }

    public function updateCourse($id)
    {
        $this->edit_mode = true;
        $this->course_to_edit = $id;
        $course = ProfessorOutsideCourse::findOrFail($id);
        $this->name = $course->name;
        $this->institution = $course->institution;
        $this->year = $course->year;
        $this->country_id = $course->country_id;
        $this->town = $course->town;
        $this->language_id = $course->language_id;
        $this->is_graduate = $course->is_graduate ? true : false;
        $this->session_id = $course->session_id;
        $this->notes = $course->notes;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['name', 'institution', 'year', 'country_id', 'town', 'language_id', 'is_graduate', 'session_id', 'notes', 'edit_mode', 'course_to_edit']);
        $this->mount();
    }
}
