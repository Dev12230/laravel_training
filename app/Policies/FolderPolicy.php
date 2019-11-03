<?php

namespace App\Policies;

use App\User;
use App\Folder;
use Illuminate\Auth\Access\HandlesAuthorization;

class FolderPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any folders.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if($user->can('folder-crud')){
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can view the folder.
     *
     * @param  \App\User  $user
     * @param  \App\Folder  $folder
     * @return mixed
     */
    public function view(User $user, Folder $folder)
    {
        if($folder->permitted->contains($user->staff)&& $user->can('folder-crud')){
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can create folders.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->can('folder-crud')){
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can update the folder.
     *
     * @param  \App\User  $user
     * @param  \App\Folder  $folder
     * @return mixed
     */
    public function update(User $user, Folder $folder)
    {
        if($folder->permitted->contains($user->staff)&& $user->can('folder-crud')){
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can delete the folder.
     *
     * @param  \App\User  $user
     * @param  \App\Folder  $folder
     * @return mixed
     */
    public function delete(User $user, Folder $folder)
    {
        if($folder->permitted->contains($user->staff)&& $user->can('folder-crud')){
            return true;
        }
        return false;
    }
}
