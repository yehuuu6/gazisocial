<?php

namespace App\Livewire\Components\Post;

use App\Models\Like;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Database\Eloquent\Relations\Relation;

class Comment extends Component
{

    use LivewireAlert;

    public $comment;

    public $postAuthor;

    public function isLikedByUser(): bool
    {
        return $this->comment->likes->contains('user_id', Auth::id());
    }

    public function toggleLike()
    {
        if (! $this->isLikedByUser()) {

            $this->authorize('create', [Like::class, $this->comment]);

            $likeable = Relation::getMorphedModel('comment')::findOrFail($this->comment->id);

            $likeable->likes()->create([
                'user_id' => Auth::id(),
            ]);

            $likeable->increment('likes_count');

            $msg = 'Yorum beğenildi.';
        } else {

            $this->authorize('delete', [Like::class, $this->comment]);

            $this->comment->likes()->whereBelongsTo(Auth::user())->delete();
            $this->comment->decrement('likes_count');
            $msg = 'Yorum beğenisi kaldırıldı.';
        }

        $this->alert('success', $msg);

        $this->comment->refresh();
    }

    public function deleteComment()
    {

        $response = Gate::inspect('delete', $this->comment);

        if (!$response->allowed()) {
            $this->alert('error', 'Bu yorumu silme izniniz yok.');
            return;
        }

        $this->comment->delete();

        $this->comment->post->decrement('comments_count');

        $this->alert('success', 'Yorum silindi.');

        $this->dispatch('comment-deleted');
    }

    public function render()
    {
        return view('livewire.components.post.comment');
    }
}
