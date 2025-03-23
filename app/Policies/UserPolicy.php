<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    public function view(User $user, User $model): Response
    {
        return $user->id === $model->id
            ? Response::allow()
            : Response::deny('Bu sayfayı görüntüleme izniniz yok.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->canDoCriticalAction() && $user->strongRole()->level > $model->strongRole()->level) {
            return true;
        }
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->canBeAGod()) {
            return true;
        }
        return $user->id === $model->id;
    }
}
