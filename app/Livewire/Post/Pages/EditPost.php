<?php

namespace App\Livewire\Post\Pages;

use App\Models\Tag;
use App\Models\Post;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class EditPost extends Component
{
    use WithRateLimiting;

    public Post $post;
    public string $title;
    public $content;
    public array $selectedTags = [];
    public bool $is_reported;
    public bool $didEditPost = false;

    #[Computed(cache: true)]
    public function tags()
    {
        return Tag::all();
    }

    public function mount(Post $post)
    {
        if (!Gate::allows('update', $post)) {
            abort(403);
        }

        $this->post = $post;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->selectedTags = $post->tags->pluck('id')->toArray();
        $this->is_reported = $post->is_reported;
    }

    public function updatePost()
    {
        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            Toaster::error("Çok fazla istek gönderdiniz. Lütfen {$exception->minutesUntilAvailable} dakika sonra tekrar deneyin.");
            return;
        }

        if (!Gate::allows('update', $this->post)) {
            Toaster::error('Bu gönderiyi düzenleme yetkiniz yok.');
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
                'content' => 'bail|required|min:10|max:10000'
            ], $messages);

            if (count($this->selectedTags) < 1) {
                Toaster::error('En az 1 etiket seçmelisiniz.');
                return;
            } elseif (count($this->selectedTags) > 4) {
                Toaster::error('En fazla 4 etiket seçebilirsiniz.');
                return;
            }
        } catch (ValidationException $e) {
            $errorMessage = $e->validator->errors()->first();
            Toaster::error($errorMessage);
            return;
        }

        $validated = [
            'title' => $this->title,
            'content' => $this->content,
            'is_reported' => $this->is_reported
        ];

        $this->post->update($validated);

        // Sync tags
        $this->post->tags()->sync($this->selectedTags);

        $this->didEditPost = true;

        return redirect($this->post->showRoute())->success('Konu başarıyla güncellendi.');
    }

    public function render()
    {
        return view('livewire.post.pages.edit-post')->title('Konuyu düzenle - ' . config('app.name'));
    }
}
