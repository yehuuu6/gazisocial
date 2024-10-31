<?php

namespace App\Livewire\Pages\Posts;

use App\Models\Tag;
use App\Models\Post;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditPost extends Component
{

    use LivewireAlert;

    public Post $post;

    public $title;
    public $content;
    public $isAnon;
    public $createdPolls = [];
    public $selectedTags = [];

    // Content does not set to the old value on page load.
    // createdPolls does not load properly.
    public function mount()
    {
        $this->authorize('update', $this->post);

        $this->title = $this->post->title;
        $this->content = $this->post->html;
        $this->isAnon = $this->post->is_anon;
        $this->selectedTags = $this->post->tags->pluck('id')->toArray();
        $this->createdPolls = $this->post->polls->toArray();
    }

    public function render()
    {
        return view('livewire.pages.posts.edit-post', [
            'tags' => Tag::all()
        ])->title('Konuyu düzenle - ' . config('app.name'));
    }
}
