<?php

namespace App\Livewire\Post\Search;

use App\Models\Tag;
use App\Models\Post;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Computed;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class SearchBar extends Component
{
    use WithRateLimiting;

    public string $search = '';

    #[Computed(persist: true)]
    public function tags()
    {
        // Get most popular 4 tags
        return Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(4)->get();
    }

    public function resetSearch()
    {
        $this->reset();
    }

    public function getSearchResults()
    {
        if (strlen($this->search) < 3) {
            return collect();
        }

        try {
            $this->rateLimit(25, decaySeconds: 1800);
        } catch (TooManyRequestsException $exception) {
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return collect();
        }

        return Post::search($this->search)->take(5)->get();
    }

    public function render()
    {
        return view('livewire.post.search.search-bar', [
            'posts' => $this->getSearchResults()
        ]);
    }
}
