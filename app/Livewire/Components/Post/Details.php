<?php

namespace App\Livewire\Components\Post;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Database\Eloquent\Relations\Relation;

class Details extends Component
{

    use LivewireAlert;

    public Post $post;

    public function mount()
    {
        if ($this->post->is_anon && Auth::id() !== $this->post->user_id) {
            $this->post->user->name = 'Anonim';
            $this->post->user->avatar = 'https://ui-avatars.com/api/?name=Anonymous&color=7F9CF5&background=EBF4FF';
            $this->post->user->username = 'anonymous';
        }
    }

    public function getTagColor(string $color)
    {
        return "bg-$color-500";
    }

    public function placeholder()
    {
        return view('components.posts.big-placeholder');
    }

    public function isLikedByUser(): bool
    {
        return $this->post->likes->contains('user_id', Auth::id());
    }

    public function toggleLike()
    {
        if (! $this->isLikedByUser()) {

            $response = Gate::inspect('create', [Like::class, $this->post]);

            if (! $response->allowed()) {
                $this->alert('error', 'Beğenebilmek için e-postanızı onaylayın.');
                return;
            }

            $likeable = Relation::getMorphedModel('post')::findOrFail($this->post->id);

            $likeable->likes()->create([
                'user_id' => Auth::id(),
            ]);

            $msg = 'Gönderi beğenildi.';
        } else {

            $this->authorize('delete', [Like::class, $this->post]);

            $like = $this->post->likes()->whereBelongsTo(Auth::user())->first();
            $like->delete();
            $msg = 'Gönderi beğenisi kaldırıldı.';
        }

        $this->alert('success', $msg);

        $this->refreshPage();
    }

    #[On('comment-created')]
    #[On('comment-deleted')]
    #[On('reply-added')]
    #[On('reply-deleted')]
    public function refreshPage()
    {
        $this->post->refresh();
    }

    public function render()
    {
        return view('livewire.components.post.details');
    }
}
