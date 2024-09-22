<?php

namespace App\Livewire\Components;

use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Categories extends Component
{
    public string $query = '';

    public function render()
    {
        $cacheKey = 'tags_query_' . md5($this->query);

        $tags = Cache::remember($cacheKey, now()->addDay(), function () {
            return Tag::where('name', 'like', '%' . $this->query . '%')->get();
        });

        return view('livewire.components.categories', [
            'tags' => $tags
        ]);
    }
}
