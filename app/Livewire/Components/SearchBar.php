<?php

namespace App\Livewire\Components;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;

class SearchBar extends Component
{
    public $search = '';

    public $currentRoute;
    public $targetUrl;
    public $placeholder;
    public $tagName;

    public function mount()
    {
        $this->setCurrentRoute();
        $this->setPlaceholderAndTargetUrl();
    }

    private function setCurrentRoute()
    {
        if (Route::currentRouteName() === 'livewire.update') return;

        // If current route is tags.show, update the tagName

        if (!$this->isUserRoute()) {
            $this->tagName = 'all';

            if (Route::currentRouteName() === 'tags.show') {
                $this->tagName = Route::current()->parameter('tag')->name;
            }
            if (Route::currentRouteName() === 'posts.search') {
                $this->tagName = Route::current()->parameter('tag');
            }
        }

        $this->currentRoute = Route::currentRouteName();
    }

    #[On('orderChanged')]
    public function render()
    {

        $results = $this->getSearchResults();

        return view('livewire.components.search-bar', [
            'results' => $results,
        ]);
    }

    public function getOrderType(): string
    {
        // Get the order type from session(order)
        return session('order', 'created_at');
    }

    public function isUserRoute(): bool
    {
        return $this->currentRoute === 'users.show' || $this->currentRoute === 'users.search' || $this->currentRoute === 'users.edit';
    }

    private function setPlaceholderAndTargetUrl()
    {
        if ($this->isUserRoute()) {
            $this->placeholder = 'Bir kullanıcı ara...';
            $this->targetUrl = route('users.search') . '/';
        } else {
            $this->placeholder = $this->tagName !== 'all' ? Str::ucfirst($this->tagName) . ' kategorisinde konu ara...' : 'Bir konu ara...';
            $this->targetUrl = '/posts/search/';
        }
    }

    private function getSearchResults()
    {

        if (strlen($this->search) === 0) {
            return [];
        }

        if ($this->isUserRoute()) {
            return $this->getUserSearchResults();
        } else {
            return $this->getPostSearchResults();
        }
    }

    private function getUserSearchResults()
    {
        return User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('username', 'like', '%' . $this->search . '%')
            ->latest()
            ->limit(5)
            ->get();
    }

    public function goToSearchRoute()
    {
        $query = $this->search;
        $this->search = '';

        if ($this->isUserRoute()) {
            return $this->redirect($this->targetUrl . $query, navigate: true);
        } else {
            return $this->redirect($this->targetUrl . Str::slug($this->tagName) . '/' . $query, navigate: true);
        }
    }

    private function getPostSearchResults()
    {

        if ($this->tagName !== 'all') {
            $tag = Tag::where('slug', Str::slug($this->tagName))->first();
            if (!$tag) abort(404);
            $posts = $tag
                ->posts()
                ->with(['user'])
                ->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('content', 'like', '%' . $this->search . '%');
                })
                ->latest($this->getOrderType())
                ->limit(5)
                ->get();
        } else {
            $posts = Post::with(['user'])
                ->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('content', 'like', '%' . $this->search . '%')
                ->latest()
                ->limit(5)
                ->get();
        }

        return $posts;
    }
}
