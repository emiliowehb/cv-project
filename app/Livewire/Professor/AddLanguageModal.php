<?php

namespace App\Livewire\Professor;

use App\Models\Language;
use App\Models\LanguageLevel;
use App\Models\ProfessorLanguage;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddLanguageModal extends Component
{
    public $language_id;
    public $spoken_language_level_id;
    public $written_language_level_id;
    public $professor_id;
    public $edit_mode = false;
    public $language_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'language_id' => 'required',
            'spoken_language_level_id' => 'required',
            'written_language_level_id' => 'required',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->language_id = Language::first()->id;
        $this->spoken_language_level_id = LanguageLevel::first()->id;
        $this->written_language_level_id = LanguageLevel::first()->id;
    }

    protected $listeners = [
        'update_language' => 'updateLanguage',
        'delete_language' => 'deleteLanguage',
    ];

    public function render()
    {
        $languages = Language::all();
        $languageLevels = LanguageLevel::all();
        return view('livewire.professors.add-language-modal', compact('languages', 'languageLevels'));
    }

    public function submit()
    {
        // Validate the form input data
        $this->validate();

        DB::transaction(function () {
            if ($this->edit_mode) {
                // Update the existing professor language
                $language = ProfessorLanguage::findOrFail($this->language_to_edit);
                $language->update([
                    'language_id' => $this->language_id,
                    'spoken_language_level_id' => $this->spoken_language_level_id,
                    'written_language_level_id' => $this->written_language_level_id,
                ]);
            } else {
                // Create a new professor language
                ProfessorLanguage::create([
                    'professor_id' => $this->professor_id,
                    'language_id' => $this->language_id,
                    'spoken_language_level_id' => $this->spoken_language_level_id,
                    'written_language_level_id' => $this->written_language_level_id,
                ]);
            }
        });

        // Reset the form fields after successful submission
        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Language successfully updated.' : 'Language successfully added.');
    }

    public function deleteLanguage($id)
    {
        $language = ProfessorLanguage::findOrFail($id);

        $language->delete();

        $this->dispatch('success', 'This language has been successfully deleted.');
    }

    public function updateLanguage($id)
    {
        $this->edit_mode = true;

        $this->language_to_edit = $id;
        $language = ProfessorLanguage::findOrFail($id);

        $this->language_id = $language->language_id;
        $this->spoken_language_level_id = $language->spoken_language_level_id;
        $this->written_language_level_id = $language->written_language_level_id;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
