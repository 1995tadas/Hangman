<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WordForm extends Component
{
    public $method;
    public $action;

    /**
     * Create a new component instance.
     *
     * @param $action
     * @param $method
     */
    public function __construct($action, $method)
    {
        $this->action = $action;
        $this->method = $method;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.word-form');
    }
}
