<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Sprint;
use Illuminate\Auth\Access\HandlesAuthorization;

class SprintPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        return $user->isProductOwner();
    }

    /**
     * Determine whether the user can view the sprint.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sprint  $sprint
     * @return mixed
     */
    public function view(User $user, Sprint $sprint)
    {
        return true;
    }

    /**
     * Determine whether the user can create sprints.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the sprint.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sprint  $sprint
     * @return mixed
     */
    public function update(User $user, Sprint $sprint)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the sprint.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sprint  $sprint
     * @return mixed
     */
    public function delete(User $user, Sprint $sprint)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the sprint.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sprint  $sprint
     * @return mixed
     */
    public function restore(User $user, Sprint $sprint)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the sprint.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sprint  $sprint
     * @return mixed
     */
    public function forceDelete(User $user, Sprint $sprint)
    {
        return false;
    }
}
