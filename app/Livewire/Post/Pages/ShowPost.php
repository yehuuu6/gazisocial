<?php

namespace App\Livewire\Post\Pages;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Isolate;

class ShowPost extends Component
{

    use LivewireAlert;

    public Post $post;
    public bool $isLiked = false;

    public $colorVariants = [
        'blue' => 'bg-blue-700',
        'red' => 'bg-red-700',
        'green' => 'bg-green-700',
        'yellow' => 'bg-yellow-500',
    ];

    public $userBio;

    public function mount(Request $request)
    {
        // Find the post by id and slug, if the title is not the same as the slug, redirect to the correct route permanently. (301)
        if (!Str::endsWith($this->post->showRoute(), $request->path())) {
            return redirect()->to($this->post->showRoute($request->query()), status: 301);
        }

        if ($this->post->user->bio === null || empty($this->post->user->bio)) {
            $this->userBio = 'Herhangi bir bilgi verilmemiş.';
        } else {
            $this->userBio = $this->post->user->bio;
        }
    }

    #[Isolate]
    public function toggleLike()
    {
        $this->post->toggleLike();
        $this->dispatch('like-toggled');
    }

    #[On('like-toggled')]
    /**
     * Refresh the post likes count on like toggled.
     */
    public function getLikesCount(): string
    {
        return Number::abbreviate($this->post->likes_count);
    }

    /**
     * Refresh the post comments count on comment added, reply added and comment deleted.
     */
    #[On('comment-deleted')]
    public function getCommentsCount(): string
    {
        return Number::abbreviate($this->post->getCommentsCount());
    }

    public function render()
    {
        $this->isLiked = $this->post->isLiked();

        return view('livewire.post.pages.show-post')
            ->title($this->post->title . ' - ' . config('app.name'));
    }
}
