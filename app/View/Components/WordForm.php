<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WordForm extends Component
{
    public $action;
    public $value;
    public $buttonValue;

    /**
     * Create a new component instance.
     *
     * @param $action
     * @param $buttonValue
     * @param string $value
     */
    public function __construct($action, $buttonValue, $value = '')
    {
        $this->action = $action;
        $this->buttonValue = $buttonValue;
        $this->value = $value;
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
