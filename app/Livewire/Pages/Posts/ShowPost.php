<?php

namespace App\Livewire\Pages\Posts;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ShowPost extends Component
{

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

    public function render()
    {
        $title = $this->post->title . ' - ' . config('app.name');

        return view('livewire.pages.posts.show-post')
            ->title($title);
    }
}
