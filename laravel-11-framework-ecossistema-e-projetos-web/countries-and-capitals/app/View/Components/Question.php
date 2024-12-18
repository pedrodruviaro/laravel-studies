<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Question extends Component
{


    public function __construct(
        public string $country,
        public int $totalQuestions,
        public int $currentQuestion
    ) {}


    public function render(): View|Closure|string
    {
        return view('components.question');
    }
}
