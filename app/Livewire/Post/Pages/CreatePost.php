<?php

namespace App\Livewire\Post\Pages;

use App\Models\Tag;
use App\Models\Poll;
use App\Models\Post;
use Livewire\Component;
use App\Models\PollOption;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CreatePost extends Component
{
    use WithRateLimiting, WithFileUploads;

    public string $title;
    public string $content;
    public array $selectedTags = [];
    public array $selectedPolls = [];
    public string $question = "";
    public int $optionsCount = 2;
    public array $options = [];
    public bool $showCreatePollModal = false;
    public bool $showEditPollModal = false;
    public ?Poll $editingPoll = null;
    public bool $is_anonim = false;
    public bool $is_pinned = false;
    public $images = [];
    public $newImage = null;

    public function updatedNewImage()
    {
        if (count($this->images) >= 3) {
            Toaster::warning('En fazla 3 görsel yükleyebilirsiniz.');
            $this->newImage = null;
            return;
        }

        $this->validate([
            'newImage' => 'image|max:2048', // 2MB max
        ], [
            'newImage.image' => 'Yüklenen dosya bir resim olmalıdır.',
            'newImage.max' => 'Resim boyutu en fazla 2MB olabilir.',
        ]);

        $this->images[] = $this->newImage;
        $this->newImage = null;
    }

    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->images = array_values($this->images); // Reindex array
        }
    }

    #[Computed()]
    public function tags()
    {
        return Tag::all();
    }

    #[Computed()]
    public function polls()
    {
        // Get all the post user has that hasnt been attached to a post yet.
        return Poll::with('options')->where('user_id', Auth::id())->where('is_draft', true)->get();
    }

    public function deletePoll($pollId)
    {
        $poll = Poll::find($pollId);
        $poll->delete();
        Toaster::success('Anket başarıyla silindi.');
    }

    public function mount()
    {
        $this->optionsCount = 2;
    }

    public function deleteOption($index)
    {
        if ($this->optionsCount <= 2) {
            Toaster::warning('En az 2 seçenek olmalı.');
            return;
        }

        // Remove the option at the specified index
        array_splice($this->options, $index, 1);
        $this->optionsCount--;
    }

    public function createPoll()
    {
        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

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
            'options.*.required' => 'Anketinize seçenek eklemelisiniz.',
            'options.*.min' => 'Seçenekler en az :min karakter olmalıdır.',
            'options.*.max' => 'Seçenekler en fazla :max karakter olabilir.',
        ];

        try {
            $this->validate([
                'question' => 'bail|required|min:6|max:100',
                'options' => 'bail|required|array|min:1|max:10',
                'options.*' => 'bail|required|min:1|max:100',
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
        ]);

        // Create poll options
        foreach ($this->options as $option) {
            PollOption::create([
                'poll_id' => $poll->id,
                'option' => $option,
            ]);
        }

        $this->question = "";
        $this->options = [];
        $this->optionsCount = 2;
        $this->showCreatePollModal = false;
        $this->dispatch('clear-options');

        Toaster::success('Anketiniz taslak olarak kaydedildi.');
    }

    public function editPoll($pollId)
    {
        $this->editingPoll = Poll::with('options')->find($pollId);
        $this->question = $this->editingPoll->question;
        $this->options = $this->editingPoll->options->pluck('option')->toArray();
        $this->optionsCount = count($this->options);
        $this->showEditPollModal = true;
    }

    public function updatePoll()
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
            'options.*.required' => 'Anketinize seçenek eklemelisiniz.',
            'options.*.min' => 'Seçenekler en az :min karakter olmalıdır.',
            'options.*.max' => 'Seçenekler en fazla :max karakter olabilir.',
        ];

        try {
            $this->validate([
                'question' => 'bail|required|min:6|max:100',
                'options' => 'bail|required|array|min:1|max:10',
                'options.*' => 'bail|required|min:1|max:100',
            ], $messages);
        } catch (ValidationException $e) {
            Toaster::error($e->validator->errors()->first());
            return;
        }

        // Update the poll
        $this->editingPoll->update([
            'question' => $this->question,
        ]);

        // Delete existing options
        $this->editingPoll->options()->delete();

        // Create new poll options
        foreach ($this->options as $option) {
            PollOption::create([
                'poll_id' => $this->editingPoll->id,
                'option' => $option,
            ]);
        }

        $this->question = "";
        $this->options = [];
        $this->optionsCount = 2;
        $this->showEditPollModal = false;
        $this->editingPoll = null;

        Toaster::success('Anket başarıyla güncellendi.');
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
            'images.*.image' => 'Yüklenen dosya bir resim olmalıdır.',
            'images.*.max' => 'Resim boyutu en fazla 2MB olabilir.',
            'images.max' => 'En fazla 3 resim yükleyebilirsiniz.',
        ];

        try {
            $this->validate([
                'title' => 'bail|required|min:6|max:100',
                'content' => 'bail|required|min:10|max:5000',
                'images' => 'array|max:3', // Maximum 3 images
            ], $messages);

            if (count($this->selectedTags) < 1) {
                Toaster::error('En az 1 etiket seçmelisiniz.');
                return;
            } elseif (count($this->selectedTags) > 4) {
                Toaster::error('En fazla 4 etiket seçebilirsiniz.');
                return;
            }

            if (count($this->selectedPolls) > 3) {
                Toaster::error('En fazla 3 anket seçebilirsiniz.');
                return;
            }
        } catch (ValidationException $e) {
            $errorMessage = $e->validator->errors()->first();
            Toaster::error($errorMessage);
            return;
        }

        $validated = [
            'title' => $this->title,
            'is_pinned' => $this->is_pinned,
            'content' => $this->content,
        ];

        $post = Post::create([
            ...$validated,
            'user_id' => Auth::id(),
            'is_anonim' => $this->is_anonim,
        ]);

        // Store images
        if (!empty($this->images)) {
            $imageUrls = [];
            foreach ($this->images as $image) {
                $path = $image->store('posts/images/' . $post->id, 'public');
                $imageUrls[] = Storage::url($path);
            }
            $post->update(['image_urls' => $imageUrls]);
        }

        // Attach tags to the post
        $post->tags()->attach($this->selectedTags);

        // Attach poll models to the post
        $this->attachPolls($post);

        return redirect($post->showRoute())->success('Konu başarıyla oluşturuldu.');
    }

    private function attachPolls(Post $post)
    {
        $this->validatePolls();

        foreach ($this->selectedPolls as $pollId) {
            $poll = Poll::find($pollId);
            $poll->update([
                'is_draft' => false,
            ]);
        }

        $post->polls()->attach($this->selectedPolls);
    }

    private function validatePolls()
    {
        // If the poll doesnt belong to the user, remove it from the selected polls.
        $this->selectedPolls = array_filter($this->selectedPolls, function ($pollId) {
            return Poll::where('user_id', Auth::id())->where('id', $pollId)->exists();
        });
    }

    public function render()
    {
        return view('livewire.post.pages.create-post')->title('Yeni konu oluştur - ' . config('app.name'));
    }
}
