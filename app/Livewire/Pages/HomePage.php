<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Resources\PostResource;
use App\Models\Post;

class HomePage extends Component
{

    use WithPagination;

    public function paginationSimpleView()
    {
        return 'livewire.pagination.simple';
    }

    public function render()
    {
        return view('livewire.pages.home-page', [
            'posts' => PostResource::collection(Post::with('user')->latest()->simplePaginate(10))
        ]);
    }
}
