<?php

namespace App\Policies;

use App\Models\Poll;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PollPolicy
{

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Poll $poll)
    {
        return $user->id === $poll->user_id
            ? Response::allow()
            : Response::deny('Bu anketi silme izniniz yok.');
    }
}
