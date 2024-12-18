<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Answer extends Component
{

    public function __construct(
        public string $capital
    ) {}


    public function render(): View|Closure|string
    {
        return view('components.answer');
    }
}
