<?php

namespace App\Livewire\Professor;

use App\Enums\MonthEnum;
use App\Models\Publisher;
use App\Models\WorkClassification;
use App\Models\ResearchArea;
use App\Models\PublicationStatus;
use App\Models\IntellectualContribution;
use App\Models\ProfessorTechnicalReport;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AddTechnicalReportModal extends Component
{
    public $year;
    public $month;
    public $publisher_id;
    public $identifying_number;
    public $volume;
    public $nb_pages;
    public $work_classification_id;
    public $research_area_id;
    public $notes;
    public $publication_status_id;
    public $intellectual_contribution_id;
    public $professor_id;
    public $edit_mode = false;
    public $report_to_edit;

    protected $rules;

    public function __construct()
    {
        $this->rules = [
            'year' => 'required|integer',
            'month' => 'nullable|string|max:255',
            'publisher_id' => 'required',
            'identifying_number' => 'nullable|string|max:255',
            'volume' => 'nullable|string|max:255',
            'nb_pages' => 'nullable|string|max:255',
            'work_classification_id' => 'required',
            'research_area_id' => 'required',
            'notes' => 'nullable|string|max:255',
            'publication_status_id' => 'required',
            'intellectual_contribution_id' => 'required',
        ];
    }

    public function mount()
    {
        $this->professor_id = Auth::user()->professor->id;
        $this->year = date('Y');
        $this->publisher_id = Publisher::first()->id;
        $this->work_classification_id = WorkClassification::first()->id;
        $this->research_area_id = ResearchArea::first()->id;
        $this->publication_status_id = PublicationStatus::first()->id;
        $this->intellectual_contribution_id = IntellectualContribution::first()->id;
    }

    protected $listeners = [
        'update_report' => 'updateReport',
        'delete_report' => 'deleteReport',
        'modal_closed' => 'resetForm',
    ];

    public function render()
    {
        $publishers = Publisher::all();
        $workClassifications = WorkClassification::all();
        $researchAreas = ResearchArea::all();
        $publicationStatuses = PublicationStatus::all();
        $intellectualContributions = IntellectualContribution::all();
        $months = MonthEnum::hash();

        return view('livewire.professors.add-technical-report-modal', compact('publishers', 'workClassifications', 'researchAreas', 'months', 'publicationStatuses', 'intellectualContributions'));
    }

    public function submit()
    {
        $this->validate();

        DB::transaction(function () {
            $data = [
                'professor_id' => $this->professor_id,
                'year' => $this->year,
                'month' => $this->month,
                'publisher_id' => $this->publisher_id,
                'identifying_number' => $this->identifying_number,
                'volume' => $this->volume,
                'nb_pages' => $this->nb_pages,
                'work_classification_id' => $this->work_classification_id,
                'research_area_id' => $this->research_area_id,
                'notes' => $this->notes,
                'publication_status_id' => $this->publication_status_id,
                'intellectual_contribution_id' => $this->intellectual_contribution_id,
            ];

            if ($this->edit_mode) {
                $report = ProfessorTechnicalReport::findOrFail($this->report_to_edit);
                $report->update($data);
            } else {
                ProfessorTechnicalReport::create($data);
            }
        });

        $this->hydrate();

        $this->dispatch('success', $this->edit_mode ? 'Technical report successfully updated.' : 'Technical report successfully added.');
    }

    public function deleteReport($id)
    {
        $report = ProfessorTechnicalReport::findOrFail($id);
        $report->delete();
        $this->dispatch('success', 'This technical report has been successfully deleted.');
    }

    public function updateReport($id)
    {
        $this->edit_mode = true;
        $this->report_to_edit = $id;
        $report = ProfessorTechnicalReport::findOrFail($id);
        $this->year = $report->year;
        $this->month = $report->month;
        $this->publisher_id = $report->publisher_id;
        $this->identifying_number = $report->identifying_number;
        $this->volume = $report->volume;
        $this->nb_pages = $report->nb_pages;
        $this->work_classification_id = $report->work_classification_id;
        $this->research_area_id = $report->research_area_id;
        $this->notes = $report->notes;
        $this->publication_status_id = $report->publication_status_id;
        $this->intellectual_contribution_id = $report->intellectual_contribution_id;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['year', 'month', 'publisher_id', 'identifying_number', 'volume', 'nb_pages', 'work_classification_id', 'research_area_id', 'notes', 'publication_status_id', 'intellectual_contribution_id', 'edit_mode', 'report_to_edit']);
        $this->mount();
    }
}
