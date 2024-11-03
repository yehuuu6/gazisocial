<?php

namespace App\Livewire\Pages\Posts;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ShowPost extends Component
{

    use WithPagination, WithoutUrlPagination, LivewireAlert;

    public Post $post;

    public $commentSortType = 'popularity';

    public function mount(Request $request)
    {
        if (!Str::endsWith($this->post->showRoute(), $request->path())) {
            return redirect()->to($this->post->showRoute($request->query()), status: 301);
        }
    }

    public function sortBy($type)
    {
        if ($this->commentSortType === $type) {
            return;
        }

        if (!in_array($type, ['latest', 'popularity'])) {
            $this->commentSortType = 'popularity';
        }

        $this->commentSortType = $type;
    }

    public function updatingPage()
    {
        $this->dispatch('scroll-to-header');
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

    public function render()
    {
        $title = $this->post->title . ' - ' . config('app.name');

        $comments = $this->post->comments()
            ->with([
                'user',
                'post',
                'likes',
            ])
            ->when($this->commentSortType === 'latest', fn($query) => $query->latest())
            ->when($this->commentSortType === 'popularity', fn($query) => $query->orderByDesc('popularity'))
            ->simplePaginate(10);

        // Check if any session flash data exists
        if (session()->has('post-created')) {
            $this->alert('success', session('post-created'));
        }

        if (session()->has('post-updated')) {
            $this->alert('success', session('post-updated'));
        }

        return view('livewire.pages.posts.show-post', compact('comments'))
            ->title($title);
    }
}
