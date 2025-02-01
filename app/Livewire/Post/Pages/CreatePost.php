<?php

namespace App\Livewire\Post\Pages;

use App\Models\Tag;
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

    public $title;
    public $content;
    public $selectedTags = [];

    #[Computed(cache: true)]
    public function tags()
    {
        return Tag::all();
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
