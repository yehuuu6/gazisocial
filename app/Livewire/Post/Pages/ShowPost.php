<?php

namespace App\Livewire\Post\Pages;

use App\Models\Post;
use Livewire\Component;
use App\Models\Like;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Gate;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Illuminate\Support\Facades\Auth;

class ShowPost extends Component
{

    use LivewireAlert, WithRateLimiting;

    public Post $post;
    public bool $isLiked = false;
    public int $likesCount;
    public int $commentsCount;

    public $colorVariants = [
        'blue' => 'bg-blue-700',
        'red' => 'bg-red-700',
        'green' => 'bg-green-700',
        'yellow' => 'bg-yellow-500',
    ];

    public $userBio;

    public function mount(Request $request)
    {
        // Find the post by id and slug, if the title is not the same as the slug, redirect to the correct route permanently. (301)
        if (!Str::endsWith($this->post->showRoute(), $request->path())) {
            return redirect()->to($this->post->showRoute($request->query()), status: 301);
        }

        $this->isLiked = $this->post->isLiked();
        $this->likesCount = $this->post->likes_count;
        $this->commentsCount = $this->post->getCommentsCount();

        if ($this->post->user->bio === null || empty($this->post->user->bio)) {
            $this->userBio = 'Herhangi bir bilgi verilmemiş.';
        } else {
            $this->userBio = $this->post->user->bio;
        }
    }

    public function toggleLike()
    {

        if (!Auth::check()) {
            $this->dispatch('auth-required', msg: 'Gönderileri beğenmek için');
            return;
        }

        try {
            $this->rateLimit(50, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            $this->dispatch('blocked-from-liking');
            $this->alert('error', "Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        // Check if the post is liked by the user.

        if ($this->post->isLiked()) {
            $response = Gate::inspect('delete', [Like::class, $this->post]);
            if (!$response->allowed()) {
                $this->alert('error', 'Bu işlemi yapmak için yetkiniz yok.');
                return;
            }
        } else {
            $response = Gate::inspect('create', [Like::class, $this->post]);
            if (!$response->allowed()) {
                $this->alert('error', 'Bu işlemi yapmak için yetkiniz yok.');
                return;
            }
        }

        $this->post->toggleLike();
    }

    public function render()
    {
        $this->isLiked = $this->post->isLiked();

        return view('livewire.post.pages.show-post')
            ->title($this->post->title . ' - ' . config('app.name'));
    }
}
