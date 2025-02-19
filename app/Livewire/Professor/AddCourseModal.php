<?php

namespace App\Livewire\Professor;

use App\Models\Language;
use App\Models\CourseLevel;
use App\Models\CourseType;
use App\Models\CourseCredit;
use App\Models\CourseCategory;
use App\Models\CourseProgram;
use App\Models\CourseTopic;
use App\Models\ProfessorCourse;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddCourseModal extends Component
{
    public $code;
    public $title;
    public $language_id;
    public $course_level_id;
    public $course_type_id;
    public $course_credit_id;
    public $course_category_id;
    public $course_program_id;
    public $course_topic_id;
    public $is_graduate;
    public $professor_id;
    public $edit_mode = false;
    public $course_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'code' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'language_id' => 'required',
            'course_level_id' => 'required',
            'course_type_id' => 'required',
            'course_credit_id' => 'required',
            'course_category_id' => 'required',
            'course_program_id' => 'required',
            'course_topic_id' => 'required',
            'is_graduate' => 'required|boolean',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->is_graduate = 0;
        $this->course_level_id = CourseLevel::first()->id;
        $this->course_type_id = CourseType::first()->id;
        $this->course_credit_id = CourseCredit::first()->id;
        $this->course_category_id = CourseCategory::first()->id;
        $this->course_program_id = CourseProgram::first()->id;
        $this->course_topic_id = CourseTopic::first()->id;
    }

    protected $listeners = [
        'update_course' => 'updateCourse',
        'delete_course' => 'deleteCourse',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $languages = Language::all();
        $courseLevels = CourseLevel::all();
        $courseTypes = CourseType::all();
        $courseCredits = CourseCredit::all();
        $courseCategories = CourseCategory::all();
        $coursePrograms = CourseProgram::all();
        $courseTopics = CourseTopic::all();

        return view('livewire.professors.add-course-modal', compact('languages', 'courseLevels', 'courseTypes', 'courseCredits', 'courseCategories', 'coursePrograms', 'courseTopics'));
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $data = [
                'professor_id' => $this->professor_id,
                'code' => $this->code,
                'title' => $this->title,
                'language_id' => $this->language_id,
                'course_level_id' => $this->course_level_id,
                'course_type_id' => $this->course_type_id,
                'course_credit_id' => $this->course_credit_id,
                'course_category_id' => $this->course_category_id,
                'course_program_id' => $this->course_program_id,
                'course_topic_id' => $this->course_topic_id,
                'is_graduate' => $this->is_graduate ? 1 : 0,
            ];

            if ($this->edit_mode) {
                $course = ProfessorCourse::findOrFail($this->course_to_edit);
                $course->update($data);
            } else {
                ProfessorCourse::create($data);
            }
        });

        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Course successfully updated.' : 'Course successfully added.');
    }

    public function deleteCourse($id)
    {
        $course = ProfessorCourse::findOrFail($id);
        $course->delete();
        $this->dispatch('success', 'This course has been successfully deleted.');
    }

    public function updateCourse($id)
    {
        $this->edit_mode = true;
        $this->course_to_edit = $id;
        $course = ProfessorCourse::findOrFail($id);
        $this->code = $course->code;
        $this->title = $course->title;
        $this->language_id = $course->language_id;
        $this->course_level_id = $course->course_level_id;
        $this->course_type_id = $course->course_type_id;
        $this->course_credit_id = $course->course_credit_id;
        $this->course_category_id = $course->course_category_id;
        $this->course_program_id = $course->course_program_id;
        $this->course_topic_id = $course->course_topic_id;
        $this->is_graduate = $course->is_graduate ? true : false;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['code', 'title', 'language_id', 'course_level_id', 'course_type_id', 'course_credit_id', 'course_category_id', 'course_program_id', 'course_topic_id', 'is_graduate', 'edit_mode', 'course_to_edit']);
        $this->mount();
    }
}
