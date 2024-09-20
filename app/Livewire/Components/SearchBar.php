<?php

namespace App\Livewire\Components;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Route;

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

        // If current route is category.show, update the tagName

        if (!$this->isUserRoute()) {
            if (Route::currentRouteName() === 'category.show') {
                $this->tagName = Route::current()->parameter('tag')->name;
            } else if (Route::currentRouteName() === 'post.search') {
                $this->tagName = Route::current()->parameter('category');
            } else {
                $this->tagName = 'all';
            }
        }

        $this->currentRoute = Route::currentRouteName();
    }

    public function render()
    {

        $results = $this->getSearchResults();

        return view('livewire.components.search-bar', [
            'results' => $results,
        ]);
    }

    public function isUserRoute(): bool
    {
        return $this->currentRoute === 'user.show' || $this->currentRoute === 'user.search' || $this->currentRoute === 'user.edit';
    }

    private function setPlaceholderAndTargetUrl()
    {
        if ($this->isUserRoute()) {
            $this->placeholder = 'Bir kullanıcı ara...';
            $this->targetUrl = '/u/search/';
        } else {
            $this->placeholder = $this->tagName !== 'all' ? 'Bu kategoride konu ara...' : 'Bir konu ara...';
            $this->targetUrl = '/posts/search/';
        }
    }

    private function getSearchResults()
    {

        if (strlen($this->search) < 2) {
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
            return $this->redirect($this->targetUrl . $this->tagName . '/' . $query, navigate: true);
        }
    }

    private function getPostSearchResults()
    {

        if ($this->tagName !== 'all') {
            $tag = Tag::where('name', $this->tagName)->first();
            $posts = $tag
                ->posts()
                ->with(['user'])
                ->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('content', 'like', '%' . $this->search . '%');
                })
                ->latest('created_at')
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
