<?php

namespace App\Livewire\Components\Post;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;
use Illuminate\Database\Eloquent\Relations\Relation;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class ReplyDetails extends Component
{

    use LivewireAlert;

    public Post $post;
    public Comment $comment;

    public function isLikedByUser(): bool
    {
        return $this->comment->likes->contains('user_id', Auth::id());
    }

    public function toggleLike()
    {
        if (! $this->isLikedByUser()) {

            $response = Gate::inspect('create', [Like::class, $this->comment]);

            if (! $response->allowed()) {
                $this->alert('error', 'Beğenebilmek için e-postanızı onaylayın.');
                return;
            }

            $likeable = Relation::getMorphedModel('comment')::findOrFail($this->comment->id);

            $likeable->likes()->create([
                'user_id' => Auth::id(),
            ]);

            $msg = 'Gönderi beğenildi.';
        } else {

            $this->authorize('delete', [Like::class, $this->comment]);

            $like = $this->comment->likes()->whereBelongsTo(Auth::user())->first();
            $like->delete();
            $msg = 'Gönderi beğenisi kaldırıldı.';
        }

        $this->alert('success', $msg);

        $this->refreshPage();
    }

    #[On('reply-added')]
    #[On('reply-deleted')]
    public function refreshPage()
    {
        $this->comment->refresh();
    }

    public function render()
    {
        return view('livewire.components.post.reply-details');
    }
}
