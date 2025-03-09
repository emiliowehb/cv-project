<?php

namespace App\Livewire\Professor;

use App\Enums\ArticleStatusEnum;
use App\Enums\MonthEnum;
use App\Models\BookType;
use App\Models\Publisher;
use App\Models\ResearchArea;
use App\Models\WorkClassification;
use App\Models\IntellectualContribution;
use App\Models\ProfessorBookChapter;
use App\Models\Reviewable;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddBookChapterModal extends Component
{
    public $book_name;
    public $chapter_title;
    public $published_year;
    public $published_month;
    public $book_type_id;
    public $professor_id;
    public $work_classification_id;
    public $volume;
    public $research_area_id;
    public $nb_pages;
    public $publisher_id;
    public $intellectual_contribution_id;
    public $notes;
    public $edit_mode = false;
    public $chapter_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'book_name' => 'required|string|max:255',
            'chapter_title' => 'required|string|max:255',
            'published_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'published_month' => 'required|string|max:255',
            'book_type_id' => 'required',
            'work_classification_id' => 'required',
            'volume' => 'nullable|string|max:255',
            'research_area_id' => 'required',
            'nb_pages' => 'nullable|integer',
            'publisher_id' => 'required',
            'intellectual_contribution_id' => 'required',
            'notes' => 'nullable|string|max:255',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->published_year = date('Y');
        $this->published_month = MonthEnum::JANUARY->value;
        $this->book_type_id = BookType::first()->id;
        $this->publisher_id = Publisher::first()->id;
        $this->work_classification_id = WorkClassification::first()->id;
        $this->research_area_id = ResearchArea::first()->id;
        $this->intellectual_contribution_id = IntellectualContribution::first()->id;
    }

    protected $listeners = [
        'update_chapter' => 'updateChapter',
        'delete_chapter' => 'deleteChapter',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $bookTypes = BookType::all();
        $publishers = Publisher::all();
        $workClassifications = WorkClassification::all();
        $researchAreas = ResearchArea::all();
        $intellectualContributions = IntellectualContribution::all();
        $months = MonthEnum::hash();
        return view('livewire.professors.add-book-chapter-modal', compact('bookTypes', 'publishers', 'workClassifications', 'researchAreas', 'intellectualContributions', 'months'));
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            if ($this->edit_mode) {
                $chapter = ProfessorBookChapter::findOrFail($this->chapter_to_edit);
                $chapter->update([
                    'book_name' => $this->book_name,
                    'chapter_title' => $this->chapter_title,
                    'published_year' => $this->published_year,
                    'published_month' => $this->published_month,
                    'book_type_id' => $this->book_type_id,
                    'work_classification_id' => $this->work_classification_id,
                    'volume' => $this->volume,
                    'research_area_id' => $this->research_area_id,
                    'nb_pages' => $this->nb_pages,
                    'publisher_id' => $this->publisher_id,
                    'intellectual_contribution_id' => $this->intellectual_contribution_id,
                    'notes' => $this->notes,
                ]);
            } else {
                $chapter = ProfessorBookChapter::create([
                    'professor_id' => $this->professor_id,
                    'book_name' => $this->book_name,
                    'chapter_title' => $this->chapter_title,
                    'published_year' => $this->published_year,
                    'published_month' => $this->published_month,
                    'book_type_id' => $this->book_type_id,
                    'work_classification_id' => $this->work_classification_id,
                    'volume' => $this->volume,
                    'research_area_id' => $this->research_area_id,
                    'nb_pages' => $this->nb_pages,
                    'publisher_id' => $this->publisher_id,
                    'intellectual_contribution_id' => $this->intellectual_contribution_id,
                    'notes' => $this->notes,
                ]);
            }

            $review = new Reviewable([
                'reviewable_type' => ProfessorBookChapter::class,
                'status' => ArticleStatusEnum::WAITING_FOR_VALIDATION,
                'type_id' => null, 
                'professor_id' => $this->professor_id,
                'reviewable_id' => $chapter ? $chapter->id : $this->chapter_to_edit,
                'reason' => null,
            ]);

            $review->save();
        });

        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Book Chapter successfully updated.' : 'Book Chapter successfully added.');
    }

    public function deleteChapter($id)
    {
        $chapter = ProfessorBookChapter::findOrFail($id);
        $chapter->delete();
        $this->dispatch('success', 'This book chapter has been successfully deleted.');
    }

    public function updateChapter($id)
    {
        $this->edit_mode = true;
        $this->chapter_to_edit = $id;
        $chapter = ProfessorBookChapter::findOrFail($id);
        $this->book_name = $chapter->book_name;
        $this->chapter_title = $chapter->chapter_title;
        $this->published_year = $chapter->published_year;
        $this->published_month = $chapter->published_month;
        $this->book_type_id = $chapter->book_type_id;
        $this->work_classification_id = $chapter->work_classification_id;
        $this->volume = $chapter->volume;
        $this->research_area_id = $chapter->research_area_id;
        $this->nb_pages = $chapter->nb_pages;
        $this->publisher_id = $chapter->publisher_id;
        $this->intellectual_contribution_id = $chapter->intellectual_contribution_id;
        $this->notes = $chapter->notes;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['book_name', 'chapter_title', 'published_year', 'published_month', 'book_type_id', 'work_classification_id', 'volume', 'research_area_id', 'nb_pages', 'publisher_id', 'intellectual_contribution_id', 'notes', 'edit_mode', 'chapter_to_edit']);
        $this->mount();
    }
}
