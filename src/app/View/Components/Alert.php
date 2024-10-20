<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public $success;
    public $error;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->success = session('success');
        $this->error = session('error');
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
