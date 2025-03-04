<?php

namespace App\Livewire\ProfessorSubmissions;

use App\Enums\ArticleStatusEnum;
use App\Models\Reviewable;
use Livewire\Component;

class ReviewableDecisionModal extends Component
{
    public $reviewable_id;
    public $reason;

    protected $listeners = [
        'approveReviewable' => 'approveReviewable',
        'denyReviewable' => 'denyReviewable',
    ];

    public function render()
    {
        return view('livewire.professor-submissions.reviewable-decision-modal');
    }


    public function approveReviewable($id)
    {
        $reviewable = Reviewable::find($id);
        $reviewable->status = ArticleStatusEnum::VALIDATED;
        $reviewable->save();

        $this->dispatch('success', 'This submission has been successfully validated.');
    }

    public function denyReviewable($id) 
    {
        $this->reviewable_id = $id;
    }

    public function submit()
    {
        $this->validate([
            'reason' => 'required|string|max:255',
        ]);

        $reviewable = Reviewable::find($this->reviewable_id);
        $reviewable->status = ArticleStatusEnum::REJECTED;
        $reviewable->reason = $this->reason;
        $reviewable->save();

        $this->dispatch('success', 'This submission has been successfully rejected.');
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->reset(['reason', 'reviewable_id']);
    }
}
