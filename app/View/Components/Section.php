<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Section extends Component
{
    public string $title;

    public string $section_title;

    public string $section_subtitle;

    public string $prev_section;

    public string $next_section;

    public string $alignment;

    public int $section_number;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $sectionTitle, $sectionSubtitle, $prevSection = '', $nextSection = '', $alignment = 'left', $sectionNumber = 1)
    {
        $this->title = $title;
        $this->section_title = $sectionTitle;
        $this->section_subtitle = $sectionSubtitle;
        $this->prev_section = $prevSection;
        $this->next_section = $nextSection;
        $this->alignment = $alignment;
        $this->section_number = $sectionNumber;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.section');
    }
}
