<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LogoOnForms extends Component
{
    public $action;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action)
    {
        $this->action = $action;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.logo-on-forms');
    }
}
