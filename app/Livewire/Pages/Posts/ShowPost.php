<?php

namespace App\Livewire\Pages\Posts;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ShowPost extends Component
{

    use WithPagination, WithoutUrlPagination, LivewireAlert;

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
        $comments = $this->post->comments()->with('user:id,name,username,avatar')->latest()->simplePaginate(10);

        // Check if any session flash data exists
        if (session()->has('post-created')) {
            $this->alert('success', session('post-created'));
        }

        return view('livewire.pages.posts.show-post', compact('comments'))
        ->title($title);
    }
}
