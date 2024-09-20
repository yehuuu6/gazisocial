<?php

namespace App\Livewire\Components\Post;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Details extends Component
{

    use LivewireAlert;

    public Post $post;

    protected $selectedColors = [];

    public function getRandomColorForTag()
    {
        $colorVariants = [
            'blue' => 'bg-blue-500',
            'red' => 'bg-red-500',
            'green' => 'bg-green-500',
            'yellow' => 'bg-yellow-500',
            'indigo' => 'bg-indigo-500',
            'purple' => 'bg-purple-500',
        ];

        shuffle($colorVariants);

        foreach ($colorVariants as $color) {
            if (!in_array($color, $this->selectedColors)) {
                $this->selectedColors[] = $color;
                return $color;
            }
        }

        // All colors are already selected, handle as needed
        return "bg-gray-700";
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

            $this->authorize('create', [Like::class, $this->post]);

            $likeable = Relation::getMorphedModel('post')::findOrFail($this->post->id);

            $likeable->likes()->create([
                'user_id' => Auth::id(),
            ]);

            $likeable->increment('likes_count');

            $msg = 'Gönderi beğenildi.';
        } else {

            $this->authorize('delete', [Like::class, $this->post]);

            $this->post->likes()->whereBelongsTo(Auth::user())->delete();
            $this->post->decrement('likes_count');
            $msg = 'Gönderi beğenisi kaldırıldı.';
        }

        $this->alert('success', $msg);

        $this->refreshPage();
    }

    public function deletePost()
    {

        $response = Gate::inspect('delete', $this->post);

        if (!$response->allowed()) {
            $this->alert('error', 'Bu konuyu silme izniniz yok.');
            return;
        }

        $this->post->delete();

        session()->flash('post-deleted', 'Konu başarıyla silindi.');

        $this->redirect(route('user.show', $this->post->user), navigate: true);
    }

    #[On('comment-created')]
    #[On('comment-deleted')]
    public function refreshPage()
    {
        $this->post->refresh();
    }

    public function render()
    {
        return view('livewire.components.post.details');
    }
}
