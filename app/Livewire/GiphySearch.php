<?php

namespace App\Livewire;

use App\Http\Controllers\GiphyController;
use Livewire\Component;
use Livewire\Attributes\Computed;

class GiphySearch extends Component
{
    public string $query = '';
    private GiphyController $giphyController;

    public function boot(GiphyController $giphyController)
    {
        $this->giphyController = $giphyController;
    }

    public function placeholder()
    {
        return view('components.post.giphy-placeholder');
    }

    #[Computed]
    public function gifs(): array
    {
        if (empty($this->query)) {
            return $this->giphyController->trending();
        }

        return $this->giphyController->search($this->query);
    }

    public function render()
    {
        return view('livewire.giphy-search');
    }
}
