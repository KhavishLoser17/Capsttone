<?php

namespace App\Livewire\Other;

use Livewire\Component;

class Breadcrumbs extends Component
{
    public $breadcrumbs = [];

    public function mount()
    {
        $this->generateBreadcrumbs();
    }

    public function generateBreadcrumbs()
    {
        // Example breadcrumb generation logic
        $segments = request()->segments();
        $this->breadcrumbs = [];

        foreach ($segments as $key => $segment) {
            $this->breadcrumbs[] = [
                'name' => ucfirst($segment),
                'url' => implode('/', array_slice($segments, 0, $key + 1)),
            ];
        }
    }

    public function render()
    {
        return view('livewire.other.breadcrumbs');
    }
}
