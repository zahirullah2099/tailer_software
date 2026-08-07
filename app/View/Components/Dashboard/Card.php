<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public string $title,
        public string $value,
        public string $icon,
        public string $color = 'blue'
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.dashboard.card');
    }
}
