<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageGallery extends Component
{
    public array $images;
    public bool $showGallery;

    /**
     * Create a new component instance.
     */
    public function __construct(array $images)
    {
        $this->images = $images;
        $this->showGallery = false;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image-gallery');
    }
}
