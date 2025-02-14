<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardStatistic extends Component
{
    public $title;
    public $icon;
    public $heading;
    public $smallNumber = null;
    public $color;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $icon, $heading, ?string $smallNumber, $color)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->heading = $heading;
        $this->smallNumber = $smallNumber;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard-statistic');
    }
}
