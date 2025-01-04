<?php

namespace App\Livewire\Post\Pages;

use Livewire\Component;

class SearchPost extends Component
{

    public $query;
    public $tag;

    public function render()
    {
        return view('livewire.post.pages.search-post')->title($this->query . ' için arama sonuçları - ' . config('app.name'));
    }
}
