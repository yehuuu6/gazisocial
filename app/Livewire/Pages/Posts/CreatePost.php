<?php

namespace App\Livewire\Pages\Posts;

use Livewire\Component;

class CreatePost extends Component
{
    public function render()
    {
        return view('livewire.pages.posts.create-post')->title('Yeni Konu Oluştur - ' . config('app.name'));
    }
}
