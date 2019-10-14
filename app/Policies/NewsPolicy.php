<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->can('news-list') || $user->can('news-edit') || $user->can('news-delete') || $user->can('news-show') ) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the news.
     *
     * @param  \App\User  $user
     * @param  \App\news  $news
     * @return mixed
     */
    public function view(User $user, news $news)
    {
        if ($user->can('news-list') || $user->can('news-edit') || $user->can('news-delete') || $user->can('news-show') ) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create newss.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('news-create')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the news.
     *
     * @param  \App\User  $user
     * @param  \App\news  $news
     * @return mixed
     */
    public function update(User $user, news $news)
    {
        if ($user->can('news-edit')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the news.
     *
     * @param  \App\User  $user
     * @param  \App\news  $news
     * @return mixed
     */
    public function delete(User $user, news $news)
    {
        if ($user->can('news-delete')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the news.
     *
     * @param  \App\User  $user
     * @param  \App\news  $news
     * @return mixed
     */
    public function restore(User $user, news $news)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the news.
     *
     * @param  \App\User  $user
     * @param  \App\news  $news
     * @return mixed
     */
    public function forceDelete(User $user, news $news)
    {
        //
    }
}
