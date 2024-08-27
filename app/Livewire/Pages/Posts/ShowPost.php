<?php

namespace App\Livewire\Pages\Posts;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class ShowPost extends Component
{

    use WithPagination;

    public Post $post;

    public function paginationSimpleView()
    {
        return 'livewire.pagination.simple';
    }

    public function render()
    {
        $comments = $this->post->comments()->with('user')->latest()->simplePaginate(10);
        return view('livewire.pages.posts.show-post', compact('comments'));
    }
}
