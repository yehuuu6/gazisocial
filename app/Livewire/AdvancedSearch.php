<?php

namespace App\Livewire;

use App\Models\Tag;
use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Url;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Computed;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class AdvancedSearch extends Component
{
    use WithRateLimiting;

    #[Url(as: 'q')]
    public string $search = '';

    public array $selectedTags = [];

    public function clearSearch()
    {
        $this->search = '';
    }

    // Dummy method to show loading on button click
    public function searchPosts()
    {
        $this->search = $this->search;
        $this->dispatch('scroll-to-results')->self();
    }

    #[Computed(cache: true)]
    public function tags()
    {
        return Tag::all();
    }

    #[Computed]
    public function posts()
    {
        if (empty($this->search) || strlen($this->search) < 3) {
            return collect();
        }

        try {
            $this->rateLimit(25, decaySeconds: 1800);
        } catch (TooManyRequestsException $exception) {
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return collect();
        }

        // Fetch posts and eager load the tags relationship
        $posts = Post::search($this->search)->take(10)->get()->load('tags', 'user');

        if (!empty($this->selectedTags)) {
            // Find posts that have ALL selected tags instead of ANY
            $posts = $posts->filter(function ($post) {
                $postTagIds = $post->tags->pluck('id')->toArray();

                // Check if ALL selected tags are in the post's tags
                foreach ($this->selectedTags as $tagId) {
                    if (!in_array($tagId, $postTagIds)) {
                        return false;
                    }
                }

                return true;
            });
        }

        return $posts;
    }


    public function render()
    {
        return view('livewire.advanced-search')->title('Gelişmiş arama - Gazi Social');
    }
}
