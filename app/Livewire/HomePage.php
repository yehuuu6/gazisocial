<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Computed;

class HomePage extends Component
{

    #[Computed]
    public function pinnedPosts()
    {
        return Post::with('user', 'tags')
            ->where('is_pinned', true)
            ->latest()
            ->limit(3)
            ->get();
    }

    public function test()
    {
        $this->dispatch('toast-show', [
            'type' => 'success',
            'message' => 'Operation successful!',
            'description' => 'Your action has been completed.',
            'position' => 'top-center'
        ]);
    }

    public function test2()
    {

        $this->dispatch('toast-show', [
            'type' => 'danger',
            'message' => 'Operation failed!',
            'description' => 'Your action has not been completed.',
            'position' => 'top-center'
        ]);
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
