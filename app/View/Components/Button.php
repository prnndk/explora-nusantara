<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $type;
    public $leftIcon;
    public $rightIcon;
    /**
     * Create a new component instance.
     */
    public function __construct($type, $leftIcon='',$rightIcon='')
    {
        $validTypes = ['primary','info','warning','danger','success','outline-neutral','outline-ecstasy'];
        $this->leftIcon = $leftIcon;
        $this->rightIcon = $rightIcon;

        $this->type = in_array($type, $validTypes) ? $type : 'primary';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}