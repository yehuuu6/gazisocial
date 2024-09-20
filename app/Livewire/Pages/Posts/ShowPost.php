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

    public function mount(Request $request)
    {
        if (!Str::endsWith($this->post->showRoute(), $request->path())) {
            return redirect()->to($this->post->showRoute($request->query()), status: 301);
        }
    }

    public function updatingPage()
    {
        $this->dispatch('scroll-to-header');
    }

    #[On('comment-created')]
    public function resetAndScroll()
    {
        $this->resetPage();
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
        $comments = $this->post->comments()->with('user', 'likes')->latest()->simplePaginate(10);

        // Check if any session flash data exists
        if (session()->has('post-created')) {
            $this->alert('success', session('post-created'));
        }

        return view('livewire.pages.posts.show-post', compact('comments'))
            ->title($title);
    }
}
