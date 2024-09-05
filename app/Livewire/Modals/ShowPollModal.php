<?php

namespace App\Livewire\Modals;

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use Illuminate\Support\Facades\Gate;
use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;

class ShowPollModal extends ModalComponent
{

    use LivewireAlert;

    public Poll $poll;
    public $selectedOption = null;

    public function mount(Poll $poll)
    {
        $this->poll = $poll;

        // Check if the user has already voted
        if (Auth::check()) {
            $this->selectedOption = $this->poll->votes->where('user_id', Auth::id())->first();

            if ($this->selectedOption) {
                $this->selectedOption = $this->selectedOption->poll_option_id;
            }
        }
    }

    public function selectOption(PollOption $option)
    {
        // Validate if the user is allowed to vote
        $response = Gate::inspect('create', PollVote::class);

        if (!$response->allowed()) {
            $this->alert('error', 'Oy kullanmak e-posta onaylı bir hesap gerektirir.');
            return;
        }

        $this->selectedOption = $option->id;

        // Grab the existing vote if the user has already voted
        $existingVote = $this->poll->votes->where('user_id', Auth::id())->first();

        if ($existingVote) {

            $response = Gate::inspect('update', $existingVote);

            if (!$response->allowed()) {
                $this->alert('error', 'Oyu değiştirmek için gerekli izne sahip değilsiniz.');
                return;
            }

            // If the user has already voted, do nothing if they are voting for the same option
            if ($existingVote->poll_option_id == $option->id) {
                return;
            }

            $msg = 'Oy değiştirildi!';

            // Update the existing vote
            $existingVote->poll_option_id = $option->id;
            $existingVote->save();
        } else {
            $msg = 'Başarıyla oy verdiniz!';
            // If the user is voting for the first time, create a new vote
            $vote = PollVote::make();
            $vote->poll()->associate($this->poll);
            $vote->user()->associate(Auth::user());
            $vote->option()->associate($option);
            $vote->save();
        }

        // Anketi tazele
        $this->poll = $this->poll->fresh();

        // Başarı mesajı
        $this->alert('success', $msg);
    }


    public function render()
    {
        return view('livewire.modals.show-poll-modal', [
            'poll' => $this->poll->load('options.votes')
        ]);
    }
}
