<?php

namespace App\Livewire\User\Pages;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class ShowUser extends Component
{
    use WithPagination, WithRateLimiting;

    public User $user;
    public string $activeTab = 'posts';

    #[Url(as: 'q')]
    public string $search = '';

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

    public function runSearch()
    {
        $this->dispatch('scroll-to-top');
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->dispatch('scroll-to-top');
    }

    #[Computed]
    public function isOwnProfile()
    {
        return Auth::check() && Auth::id() === $this->user->id;
    }

    public function deletePost(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        Toaster::success('Konu başarıyla silindi.');
    }

    #[Computed]
    public function posts()
    {
        if ($this->activeTab === 'comments') {
            return collect();
        }

        $query = $this->user->posts();

        // Eğer kullanıcı kendi profilini görüntülemiyorsa, anonim gönderileri filtreliyoruz
        if (!$this->isOwnProfile()) {
            $query->where('is_anonim', false);
        }

        // Search functionality using Scout
        if (strlen($this->search) >= 3 && $this->activeTab === 'posts') {
            try {
                $this->rateLimit(25, decaySeconds: 1800);
            } catch (TooManyRequestsException $exception) {
                Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
                return collect();
            }
            $searchResults = Post::search($this->search)->get();
            $query->whereIn('id', $searchResults->pluck('id'));
        }

        return $query->with('user', 'likes', 'comments', 'tags')->simplePaginate(10);
    }

    public function deleteComment(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        Toaster::success('Yorum başarıyla silindi.');
    }

    #[Computed]
    public function comments()
    {
        if ($this->activeTab === 'posts') {
            return collect();
        }

        $query = $this->user->comments();

        // Search functionality using Scout
        if (strlen($this->search) >= 3 && $this->activeTab === 'comments') {
            try {
                $this->rateLimit(25, decaySeconds: 1800);
            } catch (TooManyRequestsException $exception) {
                Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
                return collect();
            }
            $searchResults = Comment::search($this->search)->get();
            $query->whereIn('id', $searchResults->pluck('id'));
        }

        return $query->with([
            'user',
            'commentable'
        ])
            ->withCount('likes')
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);
    }

    public function render()
    {
        return view('livewire.user.pages.show-user')->title($this->user->name . ' - ' . 'Gazi Social');
    }
}
