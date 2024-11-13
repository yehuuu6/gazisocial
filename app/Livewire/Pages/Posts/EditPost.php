<?php

namespace App\Livewire\Pages\Posts;

use App\Models\Tag;
use App\Models\Poll;
use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PollOption;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Validation\ValidationException;

class EditPost extends Component
{
    // TODO: If the user updates the post without changing the content, the post will be updated with an empty content.
    // Also if the code has code blocks, TipTap editor's setContent method will not work properly.

    use LivewireAlert;

    public Post $post;

    public $title;
    public $content;
    public $isAnon = false;
    public $createdPolls = [];
    public $selectedTags = [];

    // createdPolls does not load properly.
    public function mount()
    {
        $this->authorize('update', $this->post);

        $this->title = $this->post->title;
        $this->content = $this->post->content;
        $this->isAnon = $this->post->is_anon;
        $this->selectedTags = $this->post->tags->pluck('id')->toArray();

        foreach ($this->post->polls as $poll) {
            $this->createNewPollObject($poll);
        }
    }

    // Create new option object and insert it into createdPolls array.
    // New object must follow these rules;
    // 1. id = option's id
    // 2. option = option's option
    // 3. votes_count = option's votes_count
    public function createNewOptionObject(PollOption $pollOption, $totalVotes)
    {
        $newOptionObject = [
            'id' => $pollOption->id,
            'option' => $pollOption->option,
            'votes_count' => $pollOption->votes_count,
            'percentage' => $this->calculateOptionPercentage($pollOption, $totalVotes)
        ];

        return $newOptionObject;
    }

    /**
     * Return true if any user has voted on the poll.
     * @param Poll $poll
     * @return bool
     */
    public function checkIfActive(Poll $poll)
    {
        // If the poll has votes, it is active.
        if ($poll->votes_count > 0) {
            return true;
        }

        // If the poll has no votes, it is not active.
        return false;
    }

    public function test()
    {
        dd($this->createdPolls);
    }

    // Create new poll object and insert it into createdPolls array.
    // New object must follow these rules;
    // 1. id = poll's id
    // 2. question = poll's question
    // 3. options = poll's options (array)
    public function createNewPollObject(Poll $poll)
    {
        $poll->load('options');

        $options = [];

        foreach ($poll->options as $option) {
            // Calculate percentage of each option.
            $options[] = $this->createNewOptionObject($option, $poll->votes_count);
        }

        $newPollObject = [
            'id' => $poll->id,
            'question' => $poll->question,
            'options' => $options,
            'is_active' => $this->checkIfActive($poll)
        ];

        $this->createdPolls[] = $newPollObject;
    }

    private function calculateOptionPercentage($option, $totalVotes)
    {
        if ($totalVotes === 0) return 0;

        return round(($option->votes_count / $totalVotes) * 100);
    }

    public function savePost()
    {
        $response = Gate::inspect('update', $this->post);

        if (!$response->allowed()) {
            $this->alert('error', 'Bu konuyu düzenlemek için yetkiniz yok.');
            return;
        }

        $messages = [
            "title.required" => "Konu başlığı zorunludur.",
            "title.min" => "Konu başlığı en az :min karakter olmalıdır.",
            "title.max" => "Konu başlığı en fazla :max karakter olabilir.",
            "content.required" => "Konu içeriği zorunludur.",
            "content.min" => "Konu içeriği en az :min karakter olmalıdır.",
            "content.max" => "Konu içeriği en fazla :max karakter olabilir."
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

        $this->post->update($validated);

        $this->post->tags()->sync($this->selectedTags);

        $this->flash('success', 'Konu başarıyla güncellendi.', redirect: $this->post->showRoute());
    }

    #[On('userPollDeleted')]
    public function render()
    {
        return view('livewire.pages.posts.edit-post', [
            'tags' => Tag::all()
        ])->title('Konuyu düzenle - ' . config('app.name'));
    }
}
