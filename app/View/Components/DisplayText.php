<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DisplayText extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $value;
    public $class;
    public function __construct($value, $class = "")
    {
        $this->value = $value;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
    return view('components.display-text');
    }
}
