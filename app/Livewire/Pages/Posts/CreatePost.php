<?php

namespace App\Livewire\Pages\Posts;

use Livewire\Component;
use App\Models\Post;
use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class CreatePost extends Component
{

    use LivewireAlert;

    public $title;
    public $content;
    public $createdPolls = [];

    public function removePoll($index)
    {
        unset($this->createdPolls[$index]);
        $this->createdPolls = array_values($this->createdPolls);
    }

    #[On('pollCreated')]
    public function addPollToCache($poll)
    {
        // Set max poll count to 3
        if (count($this->createdPolls) >= 3) {
            $this->alert('error', 'En fazla 3 anket oluşturabilirsiniz.');
            return;
        }
        // Insert the poll to the createdPolls array
        $this->createdPolls[] = $poll;
    }

    public function createPost()
    {
        $response = Gate::inspect('create', Post::class);

        if (!$response->allowed()) {
            $this->alert('error', 'Konu oluşturmak e-posta onaylı bir hesap gerektirir.');
            return;
        }

        $validated = $this->validate([
            'title' => 'required|min:6',
            'content' => 'required|min:10',
        ]);

        $slug = Str::slug($validated['title']);
        $validated['slug'] = $slug;

        // Create and save the post first
        $post = Post::make($validated);
        $post->user()->associate(Auth::user());
        $post->save();

        // Create poll options
        if (count($this->createdPolls) > 0) {
            foreach ($this->createdPolls as $poll) {
                $pollModel = Poll::make(['question' => $poll['question']]);
                $pollModel->post()->associate($post);
                $pollModel->save();

                foreach ($poll['options'] as $option) {
                    $optionModel = PollOption::make(['option' => $option]);
                    $optionModel->poll()->associate($pollModel);
                    $optionModel->save();
                }
            }
        }

        session()->flash('post-created', 'Konu başarıyla oluşturuldu.');

        return $this->redirect(route('post.show', $post->slug), navigate: true);
    }

    public function render()
    {
        return view('livewire.pages.posts.create-post')->title('Yeni Konu Oluştur - ' . config('app.name'));
    }
}
