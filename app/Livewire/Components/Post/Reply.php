<?php

namespace App\Livewire\Components\Post;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\Relation;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Like;

class Reply extends Component
{

    use LivewireAlert;

    public $reply;

    public function isLikedByUser(): bool
    {
        return $this->reply->likes->contains('user_id', Auth::id());
    }

    public function toggleLike()
    {
        if (! $this->isLikedByUser()) {

            $this->authorize('create', [Like::class, $this->reply]);

            $likeable = Relation::getMorphedModel('reply')::findOrFail($this->reply->id);

            $likeable->likes()->create([
                'user_id' => Auth::id(),
            ]);

            $msg = 'Yanıt beğenildi.';
        } else {

            $this->authorize('delete', [Like::class, $this->reply]);

            $this->reply->likes()->whereBelongsTo(Auth::user())->delete();
            $this->reply->decrement('likes_count');
            $msg = 'Yanıt beğenisi kaldırıldı.';
        }

        $this->alert('success', $msg);

        $this->reply->refresh();
    }

    public function render()
    {
        return view('livewire.components.post.reply');
    }
}
