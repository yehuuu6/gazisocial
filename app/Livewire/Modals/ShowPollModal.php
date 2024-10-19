<?php

namespace App\Livewire\Modals;

use App\Events\PollVoted;
use App\Models\Poll;
use Illuminate\Support\Facades\Gate;
use App\Models\PollVote;
use App\Models\PollOption;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class ShowPollModal extends Component
{
    use LivewireAlert;

    public Poll $poll;
    public $selectedOption = null;

    public function mount(Poll $poll)
    {
        $this->poll = $poll;

        $this->poll->load('votes', 'options.votes');

        // Check if the user has already voted
        if (Auth::check()) {
            $this->selectedOption = $this->poll->votes->where('user_id', Auth::id())->first();
            $this->selectedOption = $this->selectedOption ? $this->selectedOption->poll_option_id : null;
        }
    }

    public function vote($optionId)
    {
        $option = PollOption::find($optionId);

        if (!$option) return;

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

            $existingVote->load('user');

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
            PollVote::create([
                'poll_id' => $this->poll->id,
                'poll_option_id' => $option->id,
                'user_id' => Auth::id(),
            ]);
        }

        // Başarı mesajı
        $this->alert('success', $msg);

        // Broadcast the event
        PollVoted::dispatch($this->poll);
    }

    private function calculatePollOptionVotes(Poll $poll)
    {
        // Ensure the poll object is refreshed to get the latest vote counts
        $poll->refresh();

        $totalVotes = $poll->votes_count;

        if ($totalVotes === 0) {
            return $poll->options->map(function ($option) {
                $option->percentage = 0;
                return $option;
            });
        }

        return $poll->options->map(function ($option) use ($totalVotes) {
            $option->percentage = round(($option->votes_count / $totalVotes) * 100);
            return $option;
        });
    }

    #[On('echo:polls.{poll.id},PollVoted')]
    public function render()
    {
        $this->poll->options = $this->calculatePollOptionVotes($this->poll);
        return view('livewire.modals.show-poll-modal');
    }
}
