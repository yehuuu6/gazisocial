<?php

namespace App\Livewire\Pages\Posts;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\On;

class ShowPost extends Component
{

    use WithPagination, WithoutUrlPagination;

    public Post $post;

    public function updatingPage()
    {
        $this->dispatch('scroll-to-header');
    }
    public function paginationSimpleView()
    {
        return 'livewire.pagination.simple';
    }

    #[On('comment-created')]
    public function resetAndScroll(){
        $this->resetPage();
        $this->dispatch('scroll-to-header');
    }

    #[On('comment-deleted')]
    public function refreshPage(){
        $this->resetPage();
    }


    public function render()
    {
        $title = $this->post->title . ' - ' . config('app.name');
        $comments = $this->post->comments()->with('user')->latest()->simplePaginate(10);
        return view('livewire.pages.posts.show-post', compact('comments'))
        ->title($title);
    }
}
