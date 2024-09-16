<?php

namespace App\Livewire\Components;

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

    public function mount()
    {
        $this->setCurrentRoute();
        $this->setPlaceholderAndTargetUrl();
    }

    private function setCurrentRoute()
    {
        if (Route::currentRouteName() === 'livewire.update') return;

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
            $this->placeholder = 'Bir konu ara...';
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
        return $this->redirect($this->targetUrl . $this->search, navigate: true);
    }

    private function getPostSearchResults()
    {
        return Post::with(['user'])
            ->where('title', 'like', '%' . $this->search . '%')
            ->orWhere('content', 'like', '%' . $this->search . '%')
            ->latest()
            ->limit(4)
            ->get();
    }
}
