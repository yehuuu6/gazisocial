<?php

namespace App\Livewire\Modals;

use App\Models\Poll;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class DeletePollModal extends Component
{

    use LivewireAlert;

    public $pollId = null;

    public function deletePoll()
    {

        $poll = Poll::find($this->pollId);

        $response = Gate::inspect('delete', $poll);

        if (!$response->allowed()) {
            $this->alert('error', 'Bu anketi silme izniniz yok.');
            return;
        }

        $poll->delete();

        $this->alert('success', 'Anket başarıyla silindi.');

        $this->dispatch('poll-deleted');
        $this->dispatch('userPollDeleted');
    }

    public function render()
    {
        return view('livewire.modals.delete-poll-modal');
    }
}
