<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CheckboxDisplay extends Component
{

    public $checked;
    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($checked = false, $class = "")
    {
        $this->checked = filter_var($checked, FILTER_VALIDATE_BOOLEAN); // Ensure it's a boolean
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.checkbox-display');
    }
}
