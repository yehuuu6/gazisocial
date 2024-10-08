<?php

namespace App\Livewire\Modals;

use App\Models\Reply;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class DeleteReplyModal extends Component
{

    use LivewireAlert;

    public $replyId = null;

    public function deleteReply()
    {

        $reply = Reply::find($this->replyId);

        $response = Gate::inspect('delete', $reply);

        if (!$response->allowed()) {
            $this->alert('error', 'Bu yorumu silme izniniz yok.');
            return;
        }

        $reply->delete();

        $this->alert('success', 'Yorum silindi.');

        $this->dispatch('reply-deleted');
        $this->dispatch('userReplyDeleted');
    }

    public function render()
    {
        return view('livewire.modals.delete-reply-modal');
    }
}
