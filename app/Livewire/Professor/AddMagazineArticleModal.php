<?php

namespace App\Livewire\Professor;

use App\Enums\ArticleStatusEnum;
use App\Models\ArticleType;
use App\Models\ProfessorArticle;
use App\Models\Reviewable;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddMagazineArticleModal extends Component
{
    public $title;
    public $publisher_name;
    public $article_type_id;
    public $year;
    public $nb_pages;
    public $url;
    public $notes;
    public $professor_id;
    public $edit_mode = false;
    public $article_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'title' => 'required|string|max:255',
            'publisher_name' => 'required|string|max:255',
            'article_type_id' => 'required',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'nb_pages' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->year = date('Y');
        $this->article_type_id = ArticleType::where('name', 'Magazine')->first()->id;
    }

    protected $listeners = [
        'update_article' => 'updateArticle',
        'delete_article' => 'deleteArticle',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $articleTypes = ArticleType::all();
        return view('livewire.professors.add-magazine-article-modal', compact('articleTypes'));
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            if ($this->edit_mode) {
                $article = ProfessorArticle::findOrFail($this->article_to_edit);
                $article->update([
                    'title' => $this->title,
                    'publisher_name' => $this->publisher_name,
                    'year' => $this->year,
                    'article_type_id' => $this->article_type_id,
                    'nb_pages' => $this->nb_pages,
                    'url' => $this->url,
                    'notes' => $this->notes,
                ]);
            } else {
                $article = ProfessorArticle::create([
                    'professor_id' => $this->professor_id,
                    'title' => $this->title,
                    'article_type_id' => $this->article_type_id,
                    'publisher_name' => $this->publisher_name,
                    'year' => $this->year,
                    'nb_pages' => $this->nb_pages,
                    'url' => $this->url,
                    'notes' => $this->notes,
                ]);
            }

            $review = new Reviewable([
                'reviewable_type' => ProfessorArticle::class,
                'status' => ArticleStatusEnum::WAITING_FOR_VALIDATION,
                'type_id' => $this->article_type_id, 
                'reviewable_id' => $article ? $article->id : $this->article_to_edit,
                'reason' => null,
            ]);

            $review->save();
            
        });

        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Article successfully updated.' : 'Article successfully added.');
    }

    public function deleteArticle($id)
    {
        $article = ProfessorArticle::findOrFail($id);
        $article->delete();
        $this->dispatch('success', 'This article has been successfully deleted.');
    }

    public function updateArticle($id)
    {
        $this->edit_mode = true;
        $this->article_to_edit = $id;
        $article = ProfessorArticle::findOrFail($id);
        $this->title = $article->title;
        $this->publisher_name = $article->publisher_name;
        $this->year = $article->year;
        $this->nb_pages = $article->nb_pages;
        $this->article_type_id = $article->article_type_id;
        $this->url = $article->url;
        $this->notes = $article->notes;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['title', 'publisher_name', 'year', 'nb_pages', 'url', 'notes', 'edit_mode', 'article_to_edit']);
        $this->mount();
    }
}
