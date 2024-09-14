<?php

namespace App\Livewire\Components\Post;

use App\Models\Post;
use Livewire\Component;

class PostItem extends Component
{

    public Post $post;

    protected $selectedColors = [];

    public function getRandomColorForTag()
    {
        $colorVariants = [
            'blue' => 'bg-blue-500',
            'red' => 'bg-red-500',
            'green' => 'bg-green-500',
            'yellow' => 'bg-yellow-500',
            'indigo' => 'bg-indigo-500',
            'purple' => 'bg-purple-500',
        ];

        shuffle($colorVariants);

        foreach ($colorVariants as $color) {
            if (!in_array($color, $this->selectedColors)) {
                $this->selectedColors[] = $color;
                return $color;
            }
        }

        // All colors are already selected, handle as needed
        return "bg-gray-700";
    }

    public function render()
    {
        return view('livewire.components.post.post-item');
    }
}
