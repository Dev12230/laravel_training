<?php

namespace App\Policies;

use App\User;
use App\Visitor;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisitorPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any visitor.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->can('visitor-list') || $user->can('visitor-edit') || $user->can('visitor-delete')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the visitor.
     *
     * @param  \App\User  $user
     * @param  \App\visitor  $visitor
     * @return mixed
     */
    public function view(User $user, visitor $visitor)
    {
        //
    }

    /**
     * Determine whether the user can create visitor.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('visitor-create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the visitor.
     *
     * @param  \App\User  $user
     * @param  \App\visitor  $visitor
     * @return mixed
     */
    public function update(User $user, visitor $visitor)
    {
        if ($user->can('visitor-edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the visitor.
     *
     * @param  \App\User  $user
     * @param  \App\visitor  $visitor
     * @return mixed
     */
    public function delete(User $user, visitor $visitor)
    {
        if ($user->can('visitor-edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the visitor.
     *
     * @param  \App\User  $user
     * @param  \App\visitor  $visitor
     * @return mixed
     */
    public function restore(User $user, visitor $visitor)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the visitor.
     *
     * @param  \App\User  $user
     * @param  \App\visitor  $visitor
     * @return mixed
     */
    public function forceDelete(User $user, visitor $visitor)
    {
        //
    }
}
