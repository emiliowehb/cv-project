<?php

namespace App\View\Components;

use App\Models\Professor;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProfessorProfileCard extends Component
{
    private $professor;
    /**
     * Create a new component instance.
     */
    public function __construct(Professor $professor)
    {
        $this->professor = $professor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.professor-profile-card', [
            'professor' => $this->professor,
        ]);
    }
}
