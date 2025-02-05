<?php

namespace App\Livewire\Post\Pages;

use App\Models\Tag;
use App\Models\PollOption;
use App\Models\Poll;
use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Masmerise\Toaster\Toaster;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class CreatePost extends Component
{
    use WithRateLimiting;

    public string $title;
    public string $content;
    public array $selectedTags = [];
    public string $question = "";
    public string $end_date = "";
    public int $optionsCount = 2;
    public array $options = [];

    #[Computed(cache: true)]
    public function tags()
    {
        return Tag::all();
    }

    #[Computed()]
    public function polls()
    {
        return Poll::with('options')->where('user_id', Auth::id())->where('is_draft', true)->get();
    }

    public function deletePoll($pollId)
    {
        $poll = Poll::find($pollId);
        $poll->delete();
        Toaster::success('Anket başarıyla silindi.');
    }

    public function createPoll()
    {
        if (count($this->options) < 2) {
            Toaster::error('En az 2 seçenek eklemelisiniz.');
            return;
        }

        if (count($this->options) > 10) {
            Toaster::error('En fazla 10 seçenek ekleyebilirsiniz.');
            return;
        }

        // Validate using laravel validation
        $messages = [
            'question.required' => 'Anket sorusu zorunludur.',
            'question.min' => 'Anket sorusu en az :min karakter olmalıdır.',
            'question.max' => 'Anket sorusu en fazla :max karakter olabilir.',
            'end_date.date' => 'Anket bitiş tarihi geçerli bir tarih olmalıdır.',
            'options.*.required' => 'Anketinize seçenek eklemelisiniz.',
            'options.*.min' => 'Seçenekler en az :min karakter olmalıdır.',
            'options.*.max' => 'Seçenekler en fazla :max karakter olabilir.',
        ];

        try {
            $this->validate([
                'question' => 'bail|required|min:6|max:100',
                'end_date' => 'bail|date',
                'options' => 'bail|required|array|min:2|max:10',
                'options.*' => 'bail|required|min:2|max:100',
            ], $messages);
        } catch (ValidationException $e) {
            Toaster::error($e->validator->errors()->first());
            return;
        }

        // Create the poll.
        $poll = Poll::create([
            'question' => $this->question,
            'user_id' => Auth::id(),
            'is_draft' => true,
            'end_date' => $this->end_date,
        ]);

        // Create poll options
        foreach ($this->options as $option) {
            PollOption::create([
                'poll_id' => $poll->id,
                'option' => $option,
            ]);
        }

        unset($this->polls);

        $this->dispatch('poll-draft-created');

        Toaster::success('Anketiniz taslak olarak kaydedildi.');
    }

    public function createPost()
    {

        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        $response = Gate::inspect('create', Post::class);

        if (!$response->allowed()) {
            Toaster::error('Konu oluşturmak için onaylı bir hesap gereklidir.');
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
                Toaster::error('En az 1 etiket seçmelisiniz.');
                return;
            } elseif (count($this->selectedTags) > 4) {
                Toaster::error('En fazla 4 etiket seçebilirsiniz.');
                return;
            }
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $errorMessage = implode('<br>', $errors);
            Toaster::error($errorMessage);
            return;
        }

        $validated = [
            'title' => $this->title,
            'content' => $this->content,
        ];

        $post = Post::create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        // Attach tags to the post
        $post->tags()->attach($this->selectedTags);

        return redirect($post->showRoute())->success('Konu başarıyla oluşturuldu.');
    }

    public function render()
    {
        return view('livewire.post.pages.create-post')->title('Yeni konu oluştur - ' . config('app.name'));
    }
}
