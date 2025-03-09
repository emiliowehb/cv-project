<?php

namespace App\Livewire\ProfessorSubmissions;

use App\Models\Reviewable;
use Livewire\Component;

class ViewReviewableDetailsModal extends Component
{
    public $reviewable;
    public $reviewableType;
    public $reviewableDetails;

    protected $listeners = ['viewReviewableDetails'];

    public function viewReviewableDetails($reviewable)
    {
        $this->reviewable = Reviewable::find($reviewable);
        $this->reviewableType = substr($this->reviewable->reviewable_type, 11);
        $this->reviewableDetails = $this->reviewable->reviewable->getReviewableDetails();
    }

    public function render()
    {
        return view('livewire.professor-submissions.view-reviewable-details-modal');
    }
}
