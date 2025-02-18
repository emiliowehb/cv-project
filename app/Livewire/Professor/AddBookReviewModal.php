<?php

namespace App\Livewire\Professor;

use App\Enums\MonthEnum;
use App\Models\ReviewedMedium;
use App\Models\ProfessorBookReview;
use App\Models\IntellectualContribution;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddBookReviewModal extends Component
{
    public $name;
    public $year;
    public $month;
    public $reviewed_medium_id;
    public $professor_id;
    public $periodical_title;
    public $reviewed_work_authors;
    public $notes;
    public $intellectual_contribution_id;
    public $edit_mode = false;
    public $review_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'month' => 'required|string|max:255',
            'reviewed_medium_id' => 'required',
            'periodical_title' => 'required|string|max:255',
            'reviewed_work_authors' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'intellectual_contribution_id' => 'required',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->year = date('Y');
        $this->month = MonthEnum::JANUARY->value;
        $this->reviewed_medium_id = ReviewedMedium::first()->id;
        $this->intellectual_contribution_id = IntellectualContribution::first()->id;
    }

    protected $listeners = [
        'update_review' => 'updateReview',
        'delete_review' => 'deleteReview',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $reviewedMedia = ReviewedMedium::all();
        $months = MonthEnum::values();
        $intellectualContributions = IntellectualContribution::all();
        return view('livewire.professors.add-book-review-modal', compact('reviewedMedia', 'months', 'intellectualContributions'));
    }

    public function submit()
    {
        $this->validate();
        DB::transaction(function () {
            if ($this->edit_mode) {
                $review = ProfessorBookReview::findOrFail($this->review_to_edit);
                $review->update([
                    'name' => $this->name,
                    'year' => $this->year,
                    'month' => $this->month,
                    'reviewed_medium_id' => $this->reviewed_medium_id,
                    'periodical_title' => $this->periodical_title,
                    'reviewed_work_authors' => $this->reviewed_work_authors,
                    'notes' => $this->notes,
                    'intellectual_contribution_id' => $this->intellectual_contribution_id,
                ]);
            } else {
                ProfessorBookReview::create([
                    'professor_id' => $this->professor_id,
                    'name' => $this->name,
                    'year' => $this->year,
                    'month' => $this->month,
                    'reviewed_medium_id' => $this->reviewed_medium_id,
                    'periodical_title' => $this->periodical_title,
                    'reviewed_work_authors' => $this->reviewed_work_authors,
                    'notes' => $this->notes,
                    'intellectual_contribution_id' => $this->intellectual_contribution_id,
                ]);
            }
        });

        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Review successfully updated.' : 'Review successfully added.');
    }

    public function deleteReview($id)
    {
        $review = ProfessorBookReview::findOrFail($id);
        $review->delete();
        $this->dispatch('success', 'This review has been successfully deleted.');
    }

    public function updateReview($id)
    {
        $this->edit_mode = true;
        $this->review_to_edit = $id;
        $review = ProfessorBookReview::findOrFail($id);
        $this->name = $review->name;
        $this->year = $review->year;
        $this->month = $review->month;
        $this->reviewed_medium_id = $review->reviewed_medium_id;
        $this->periodical_title = $review->periodical_title;
        $this->reviewed_work_authors = $review->reviewed_work_authors;
        $this->notes = $review->notes;
        $this->intellectual_contribution_id = $review->intellectual_contribution_id;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['name', 'year', 'month', 'reviewed_medium_id', 'periodical_title', 'reviewed_work_authors', 'notes', 'intellectual_contribution_id', 'edit_mode', 'review_to_edit']);
        $this->mount();
    }
}
