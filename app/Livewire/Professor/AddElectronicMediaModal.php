<?php

namespace App\Livewire\Professor;

use App\Models\ElectronicMediaType;
use App\Models\ProfessorElectronicMedia;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AddElectronicMediaModal extends Component
{
    public $name;
    public $year;
    public $type_id;
    public $publisher;
    public $notes;
    public $professor_id;
    public $edit_mode = false;
    public $media_to_edit;

    protected $rules = [
        'name' => 'required|string|max:255',
        'year' => 'required|integer|min:1900|max:2100',
        'type_id' => 'required|exists:electronic_media_types,id',
        'publisher' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
    ];

    public $listeners = [
        'update_media' => 'editMedia',
        'delete_media' => 'deleteMedia',
        'reset_form' => 'resetForm',
    ];

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->type_id = ElectronicMediaType::first()->id;
        $this->year = date('Y');
        $this->rules['year'] = 'required|integer|min:1900|max:' . (date('Y') + 1);
    }

    public function render()
    {
        $types = ElectronicMediaType::all();
        addVendor('formrepeater');

        return view('livewire.professors.add-electronic-media-modal', compact('types'));
    }

    public function submit()
    {
        $this->validate();

        if ($this->edit_mode) {
            $media = ProfessorElectronicMedia::findOrFail($this->media_to_edit);
            $media->update([
                'name' => $this->name,
                'year' => $this->year,
                'type_id' => $this->type_id,
                'publisher' => $this->publisher,
                'notes' => $this->notes,
            ]);
        } else {
            ProfessorElectronicMedia::create([
                'professor_id' => $this->professor_id,
                'name' => $this->name,
                'year' => $this->year,
                'type_id' => $this->type_id,
                'publisher' => $this->publisher,
                'notes' => $this->notes,
            ]);
        }

        $this->resetForm();

        $this->dispatch('success', $this->edit_mode ? 'Electronic media successfully updated.' : 'Electronic media successfully added.');
    }

    public function editMedia($id)
    {
        $this->edit_mode = true;

        $this->media_to_edit = $id;
        $media = ProfessorElectronicMedia::findOrFail($id);

        $this->name = $media->name;
        $this->year = $media->year;
        $this->type_id = $media->type_id;
        $this->publisher = $media->publisher;
        $this->notes = $media->notes;
    }

    public function deleteMedia($id)
    {
        $media = ProfessorElectronicMedia::findOrFail($id);

        $media->delete();

        $this->dispatch('success', 'Electronic media successfully deleted.');
    }

    public function resetForm()
    {
        $this->reset(['name', 'year', 'type_id', 'publisher', 'notes', 'edit_mode', 'media_to_edit']);
        $this->mount();
    }
}
