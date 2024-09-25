<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActionButton extends Component
{
    public $type;
    public $user;

    public function __construct($type, $user)
    {
        $this->type = $type;
        $this->user = $user;
    }

    public function render()
    {
        return view('components.action-button');
    }
}
