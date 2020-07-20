<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormField extends Component
{
    public $name;

    public $label;

    public $type;

    public $required;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $type = 'text', $required = true)
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form-field');
    }
}
