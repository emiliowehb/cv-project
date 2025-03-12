<?php

namespace App\View\Components;

use App\Models\Author;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AuthorRepeater extends Component
{
    public string $class;
    public string $title;
    public array $selectedAuthors;

    /**
     * Create a new component instance.
     */
    public function __construct(string $class, string $title, array $selectedAuthors = [])
    {
        $this->class           = $class;
        $this->title           = $title;
        $this->selectedAuthors = $selectedAuthors;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        // Get all authors order by name
        $authors = Author::select('id', 'name')
                         ->orderBy('name')
                         ->get();
        return view('components.author-repeater', compact('authors'));
    }
}
