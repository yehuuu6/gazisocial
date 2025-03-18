<?php

namespace App\Livewire\User\Pages;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ShowUser extends Component
{
    use WithPagination;

    public User $user;
    public string $activeTab = 'posts';

    public array $colorVariants = [
        'blue' => 'bg-blue-700',
        'red' => 'bg-red-700',
        'green' => 'bg-green-700',
        'yellow' => 'bg-yellow-500',
        'orange' => 'bg-orange-500',
        'purple' => 'bg-purple-500',
    ];

    public function mount(User $user)
    {
        $this->user = $user;

        // URL'den aktif sekmeyi belirle
        $routeName = Route::currentRouteName();
        if ($routeName === 'users.comments') {
            $this->activeTab = 'comments';
        }
    }

    public function updatedPage($page)
    {
        $this->dispatch('scroll-to-top');
    }

    #[Computed]
    public function isOwnProfile()
    {
        return Auth::check() && Auth::id() === $this->user->id;
    }

    #[Computed]
    public function posts()
    {
        $query = $this->user->posts();

        // Eğer kullanıcı kendi profilini görüntülemiyorsa, anonim gönderileri filtreliyoruz
        if (!$this->isOwnProfile()) {
            $query->where('is_anonim', false);
        }

        return $query->with('user', 'likes', 'comments', 'tags')->simplePaginate(10);
    }

    #[Computed]
    public function comments()
    {
        return $this->user->comments()
            ->with([
                'user',
                'commentable'
            ])
            ->withCount('likes')
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);
    }

    public function render()
    {
        return view('livewire.user.pages.show-user');
    }
}
