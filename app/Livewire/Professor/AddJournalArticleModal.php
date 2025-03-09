<?php

namespace App\Livewire\Professor;

use App\Enums\ArticleStatusEnum;
use App\Enums\MonthEnum;
use App\Models\JournalArticleType;
use App\Models\PublicationStatus;
use App\Models\ProfessorJournalArticle;
use App\Models\PublicationPrimaryField;
use App\Models\PublicationSecondaryField;
use App\Models\Reviewable;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddJournalArticleModal extends Component
{
    public $journal_article_type_id;
    public $publication_status_id;
    public $title;
    public $volume;
    public $year;
    public $issue;
    public $pages;
    public $notes;
    public $month;
    public $primary_field_id;
    public $secondary_field_id;
    public $professor_id;
    public $edit_mode = false;
    public $article_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'journal_article_type_id' => 'required',
            'publication_status_id' => 'required',
            'title' => 'required|string|max:255',
            'volume' => 'nullable|string|max:255',
            'issue' => 'nullable|string|max:255',
            'pages' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'month' => 'required',
            'primary_field_id' => 'nullable',
            'secondary_field_id' => 'nullable',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->journal_article_type_id = JournalArticleType::first()->id;
        $this->publication_status_id = PublicationStatus::first()->id;
        $this->primary_field_id = PublicationPrimaryField::first()->id;
        $this->secondary_field_id = PublicationSecondaryField::first()->id;
        $this->year = date('Y');
        $this->month = MonthEnum::values()[0];
    }

    protected $listeners = [
        'update_jarticle' => 'updateArticle',
        'delete_jarticle' => 'deleteArticle',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $articleTypes = JournalArticleType::all();
        $publicationStatuses = PublicationStatus::all();
        $primaryFields = PublicationPrimaryField::all();
        $months = MonthEnum::hash();

        $secondaryFields = PublicationSecondaryField::all();
        return view('livewire.professors.add-journal-article-modal', compact('articleTypes','months', 'publicationStatuses', 'primaryFields', 'secondaryFields'));
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            if ($this->edit_mode) {
                $article = ProfessorJournalArticle::findOrFail($this->article_to_edit);
                $article->update([
                    'journal_article_type_id' => $this->journal_article_type_id,
                    'publication_status_id' => $this->publication_status_id,
                    'title' => $this->title,
                    'volume' => $this->volume,
                    'year' => $this->year,
                    'month' => $this->month,
                    'issue' => $this->issue,
                    'pages' => $this->pages,
                    'notes' => $this->notes,
                    'primary_field_id' => $this->primary_field_id,
                    'secondary_field_id' => $this->secondary_field_id,
                ]);
            } else {
                $article = ProfessorJournalArticle::create([
                    'professor_id' => $this->professor_id,
                    'journal_article_type_id' => $this->journal_article_type_id,
                    'publication_status_id' => $this->publication_status_id,
                    'title' => $this->title,
                    'volume' => $this->volume,
                    'year' => $this->year,
                    'month' => $this->month,
                    'issue' => $this->issue,
                    'pages' => $this->pages,
                    'notes' => $this->notes,
                    'primary_field_id' => $this->primary_field_id,
                    'secondary_field_id' => $this->secondary_field_id,
                ]);
            }

            $review = new Reviewable([
                'reviewable_type' => ProfessorJournalArticle::class,
                'status' => ArticleStatusEnum::WAITING_FOR_VALIDATION,
                'type_id' => null, 
                'professor_id' => $this->professor_id,
                'reviewable_id' => $article ? $article->id : $this->article_to_edit,
                'reason' => null,
            ]);

            $review->save();
        });

        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Journal article successfully updated.' : 'Journal article successfully added.');
    }

    public function deleteArticle($id)
    {
        $article = ProfessorJournalArticle::findOrFail($id);
        $article->delete();
        $this->dispatch('success', 'This journal article has been successfully deleted.');
    }

    public function updateArticle($id)
    {
        $this->edit_mode = true;
        $this->article_to_edit = $id;
        $article = ProfessorJournalArticle::findOrFail($id);
        $this->journal_article_type_id = $article->journal_article_type_id;
        $this->publication_status_id = $article->publication_status_id;
        $this->title = $article->title;
        $this->year = $article->year;
        $this->month = $article->month;
        $this->volume = $article->volume;
        $this->issue = $article->issue;
        $this->pages = $article->pages;
        $this->notes = $article->notes;
        $this->primary_field_id = $article->primary_field_id;
        $this->secondary_field_id = $article->secondary_field_id;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['journal_article_type_id', 'publication_status_id', 'title', 'volume', 'issue', 'pages', 'notes', 'primary_field_id', 'secondary_field_id', 'edit_mode', 'article_to_edit']);
        $this->mount();
    }
}
