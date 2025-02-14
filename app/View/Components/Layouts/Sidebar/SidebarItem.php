<?php

namespace App\View\Components\Layouts\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarItem extends Component
{

    public string $icon;
    public bool $active;
    public string $route;
    public string $title;
    public bool $isSubmenu;

    /**
     * Create a new component instance.
     */
    public function __construct(string $icon, bool $active, string $route, string $title, bool $isSubmenu)
    {
        $this->icon = $icon;
        $this->active = $active;
        $this->route = $route;
        $this->title = $title;
        $this->isSubmenu = $isSubmenu;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.sidebar.sidebar-item');
    }
}
