<?php

namespace App\Livewire\Pages\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\On;

class ListPostComments extends Component
{

    use WithPagination, WithoutUrlPagination;

    public Post $post;
    public $commentSortType = 'popularity';

    public function sortBy($type)
    {
        if ($this->commentSortType === $type) {
            return;
        }

        if (!in_array($type, ['latest', 'popularity'])) {
            $this->commentSortType = 'popularity';
        }

        $this->commentSortType = $type;

        $this->resetPage();
    }

    public function placeholder()
    {
        return view('components.posts.big-placeholder');
    }

    #[On('comment-created')]
    public function resetAndScroll()
    {
        $this->sortBy('latest');
        $this->refreshPage();
        $this->dispatch('scroll-to-header');
    }

    #[On('comment-deleted')]
    public function refreshPage()
    {
        $this->resetPage();
    }

    public function updatingPage()
    {
        $this->dispatch('scroll-to-header');
    }

    public function render()
    {
        $comments = $this->post->comments()
            ->with([
                'user',
            ])
            ->when($this->commentSortType === 'latest', fn($query) => $query->latest())
            ->when($this->commentSortType === 'popularity', fn($query) => $query->orderByDesc('popularity'))
            ->simplePaginate(10);

        return view('livewire.pages.posts.list-post-comments', compact('comments'));
    }
}
