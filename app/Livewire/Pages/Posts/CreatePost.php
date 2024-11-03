<?php

namespace App\Livewire\Pages\Posts;

use App\Models\Tag;
use Livewire\Component;
use App\Models\Post;
use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Illuminate\Validation\ValidationException;

class CreatePost extends Component
{

    use LivewireAlert;

    public $title;
    public $content;
    public $isAnon = false;
    public $createdPolls = [];
    public $selectedTags = [];

    public function removePoll($index)
    {
        unset($this->createdPolls[$index]);
        $this->createdPolls = array_values($this->createdPolls);
    }

    #[On('poll-created')]
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
            $this->alert('error', 'Konu açmak e-posta onaylı bir hesap gerektirir.');
            return;
        }

        $messages = [
            'title.required' => 'Konu başlığı zorunludur.',
            'title.min' => 'Konu başlığı en az :min karakter olmalıdır.',
            'title.max' => 'Konu başlığı en fazla :max karakter olabilir.',
            'content.required' => 'Konu içeriği zorunludur.',
            'content.min' => 'Konu içeriği en az :min karakter olmalıdır.',
            'content.max' => 'Konu içeriği en fazla :max karakter olabilir.',
        ];

        try {
            $this->validate([
                'title' => 'bail|required|min:6|max:100',
                'content' => 'bail|required|min:10|max:5000'
            ], $messages);

            if (count($this->selectedTags) < 1) {
                $this->alert('error', 'En az bir etiket seçmelisiniz.');
                return;
            } elseif (count($this->selectedTags) > 4) {
                $this->alert('error', 'En fazla 4 etiket seçebilirsiniz.');
                return;
            }
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $errorMessage = implode('<br>', $errors);
            $this->alert('error', $errorMessage);
            return;
        }

        $validated = [
            'title' => $this->title,
            'content' => $this->content,
            'is_anon' => $this->isAnon
        ];

        $post = Post::create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        // Attach tags to the post
        $post->tags()->attach($this->selectedTags);

        // Create poll options
        if (count($this->createdPolls) > 0) {
            foreach ($this->createdPolls as $poll) {
                $pollModel = Poll::create([
                    'post_id' => $post->id,
                    'question' => $poll['question']
                ]);

                foreach ($poll['options'] as $option) {
                    PollOption::create([
                        'poll_id' => $pollModel->id,
                        'option' => $option
                    ]);
                }
            }
        }

        $this->flash('success', 'Konu başarıyla oluşturuldu.', redirect: $this->post->showRoute());
    }

    public function render()
    {
        return view('livewire.pages.posts.create-post', [
            'tags' => Tag::all()
        ])->title('Yeni konu oluştur - ' . config('app.name'));
    }
}
