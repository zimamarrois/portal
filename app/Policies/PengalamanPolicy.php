<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pengalaman;
use Illuminate\Auth\Access\HandlesAuthorization;

class PengalamanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_any_pengalaman');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengalaman  $pengalaman
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Pengalaman $pengalaman)
    {
        return $user->can('view_pengalaman');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_pengalaman');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengalaman  $pengalaman
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Pengalaman $pengalaman)
    {
        return $user->can('update_pengalaman');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengalaman  $pengalaman
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Pengalaman $pengalaman)
    {
        return $user->can('delete_pengalaman');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_pengalaman');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengalaman  $pengalaman
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Pengalaman $pengalaman)
    {
        return $user->can('force_delete_pengalaman');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_pengalaman');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengalaman  $pengalaman
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Pengalaman $pengalaman)
    {
        return $user->can('restore_pengalaman');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_pengalaman');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pengalaman  $pengalaman
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, Pengalaman $pengalaman)
    {
        return $user->can('replicate_pengalaman');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_pengalaman');
    }

}
