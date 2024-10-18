<?php

namespace App\Livewire\Pages\Posts;

use Livewire\Component;

class SearchPost extends Component
{

    public $query;
    public $tag;

    public function render()
    {
        return view('livewire.pages.posts.search-post')->title($this->query . ' için arama sonuçları - ' . config('app.name'));
    }
}
