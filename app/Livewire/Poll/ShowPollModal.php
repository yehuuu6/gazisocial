<?php

namespace App\Livewire\Poll;

use Livewire\Component;
use Livewire\Attributes\On;
use Masmerise\Toaster\Toaster;
use App\Models\PollVote;
use App\Models\PollOption;
use Illuminate\Support\Facades\Gate;
use App\Models\Poll;
use Illuminate\Support\Facades\Auth;
use App\Events\PollVoted;

class ShowPollModal extends Component
{
    public Poll $poll;
    public $selectedOption;

    public function mount(Poll $poll)
    {
        $this->poll = $poll;

        $this->poll->load('options', 'votes');

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
            Toaster::error('Oy kullanmak e-posta onaylı bir hesap gerektirir.');
            return;
        }

        $this->selectedOption = $option->id;

        $poll = $option->poll;

        // Grab the existing vote if the user has already voted
        $existingVote = $poll->votes->where('user_id', Auth::id())->first();

        if ($existingVote) {

            $existingVote->load('user');

            $response = Gate::inspect('update', $existingVote);

            if (!$response->allowed()) {
                Toaster::error('Bu işlemi yapmak için yetkiniz yok.');
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
                'poll_id' => $poll->id,
                'poll_option_id' => $option->id,
                'user_id' => Auth::id(),
            ]);
        }

        // Başarı mesajı
        Toaster::success($msg);

        // Broadcast the event
        broadcast(new PollVOted($poll))->toOthers();
    }

    public function getPollPercentage(Poll $poll, PollOption $option)
    {
        $poll->load('votes',);
        $option->load('votes');
        $votesCount = $poll->votes->count();
        $optionVotesCount = $option->votes->count();

        if ($votesCount === 0) {
            return 0;
        }

        return round(($optionVotesCount / $votesCount) * 100);
    }

    #[On('echo:polls.{poll.id},PollVoted')]
    public function render()
    {
        return view('livewire.poll.show-poll-modal');
    }
}
