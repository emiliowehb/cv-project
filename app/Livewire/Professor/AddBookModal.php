<?php

namespace App\Livewire\Professor;

use App\Enums\MonthEnum;
use App\Models\BookType;
use App\Models\Publisher;
use App\Models\ResearchArea;
use App\Models\WorkClassification;
use App\Models\PublicationStatus;
use App\Models\ProfessorBook;
use App\Models\PublicationPrimaryField;
use App\Models\PublicationSecondaryField;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddBookModal extends Component
{
    public $name;
    public $year;
    public $month;
    public $book_type_id;
    public $professor_id;
    public $work_classification_id;
    public $volume;
    public $research_area_id;
    public $nb_pages;
    public $publisher_id;
    public $publication_status_id;
    public $primary_field_id;
    public $secondary_field_id;
    public $edit_mode = false;
    public $book_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'month' => 'required|string|max:255',
            'book_type_id' => 'required',
            'work_classification_id' => 'required',
            'volume' => 'nullable|string|max:255',
            'research_area_id' => 'required',
            'nb_pages' => 'nullable|integer',
            'publisher_id' => 'required',
            'publication_status_id' => 'required',
            'primary_field_id' => 'required',
            'secondary_field_id' => 'required',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->year = date('Y');
        $this->month = MonthEnum::JANUARY->value;
        $this->book_type_id = BookType::first()->id;
        $this->publisher_id = Publisher::first()->id;
        $this->work_classification_id = WorkClassification::first()->id;
        $this->research_area_id = ResearchArea::first()->id;
        $this->publication_status_id = PublicationStatus::first()->id;
        $this->primary_field_id = PublicationPrimaryField::first()->id;
        $this->secondary_field_id = PublicationSecondaryField::first()->id;
    }

    protected $listeners = [
        'update_book' => 'updateBook',
        'delete_book' => 'deleteBook',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $bookTypes = BookType::all();
        $publishers = Publisher::all();
        $workClassifications = WorkClassification::all();
        $researchAreas = ResearchArea::all();
        $publicationStatuses = PublicationStatus::all();
        $primaryFields = PublicationPrimaryField::all();
        $secondaryFields = PublicationSecondaryField::all();
        $months = MonthEnum::hash();
        return view('livewire.professors.add-book-modal', compact('bookTypes', 'publishers', 'workClassifications', 'researchAreas', 'publicationStatuses', 'primaryFields', 'secondaryFields', 'months'));
    }

    public function submit()
    {
        $this->validate();
        DB::transaction(function () {
            if ($this->edit_mode) {
                $book = ProfessorBook::findOrFail($this->book_to_edit);
                $book->update([
                    'name' => $this->name,
                    'year' => $this->year,
                    'month' => $this->month,
                    'book_type_id' => $this->book_type_id,
                    'work_classification_id' => $this->work_classification_id,
                    'volume' => $this->volume,
                    'research_area_id' => $this->research_area_id,
                    'nb_pages' => $this->nb_pages,
                    'publisher_id' => $this->publisher_id,
                    'publication_status_id' => $this->publication_status_id,
                    'primary_field_id' => $this->primary_field_id,
                    'secondary_field_id' => $this->secondary_field_id,
                ]);
            } else {
                ProfessorBook::create([
                    'professor_id' => $this->professor_id,
                    'name' => $this->name,
                    'year' => $this->year,
                    'month' => $this->month,
                    'book_type_id' => $this->book_type_id,
                    'work_classification_id' => $this->work_classification_id,
                    'volume' => $this->volume,
                    'research_area_id' => $this->research_area_id,
                    'nb_pages' => $this->nb_pages,
                    'publisher_id' => $this->publisher_id,
                    'publication_status_id' => $this->publication_status_id,
                    'primary_field_id' => $this->primary_field_id,
                    'secondary_field_id' => $this->secondary_field_id,
                ]);
            }
        });

        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Book successfully updated.' : 'Book successfully added.');
    }

    public function deleteBook($id)
    {
        $book = ProfessorBook::findOrFail($id);
        $book->delete();
        $this->dispatch('success', 'This book has been successfully deleted.');
    }

    public function updateBook($id)
    {
        $this->edit_mode = true;
        $this->book_to_edit = $id;
        $book = ProfessorBook::findOrFail($id);
        $this->name = $book->name;
        $this->year = $book->year;
        $this->month = $book->month;
        $this->book_type_id = $book->book_type_id;
        $this->work_classification_id = $book->work_classification_id;
        $this->volume = $book->volume;
        $this->research_area_id = $book->research_area_id;
        $this->nb_pages = $book->nb_pages;
        $this->publisher_id = $book->publisher_id;
        $this->publication_status_id = $book->publication_status_id;
        $this->primary_field_id = $book->primary_field_id;
        $this->secondary_field_id = $book->secondary_field_id;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['name', 'year', 'month', 'book_type_id', 'work_classification_id', 'volume', 'research_area_id', 'nb_pages', 'publisher_id', 'publication_status_id', 'primary_field_id', 'secondary_field_id', 'edit_mode', 'book_to_edit']);
        $this->mount();
    }
}
