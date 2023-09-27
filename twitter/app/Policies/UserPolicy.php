<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Follower;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }

    /**
     * Authユーザーと表示されているユーザーのIDが一致しない場合のみフォロー・アンフォローボタンを表示
     *
     * @param User $authUser
     * @param User $targetUser
     * @return void
     */
    public function followOrUnfollow(User $authUser, User $targetUser)
    {
        return $authUser->id !== $targetUser->id;
    }

    /**
     * すでにフォローしている場合はfalseを返す
     *
     * @param User $authUser
     * @param User $targetUser
     * @return bool
     */
    public function follow(User $authUser, User $targetUser)
    {
        $follower = new Follower();
        return !$follower->isFollowing($targetUser->id);
    }

    /**
     * フォローしている場合はtrueを返す
     *
     * @param User $authUser
     * @param User $targetUser
     * @return bool
     */
    public function unfollow(User $authUser, User $targetUser)
    {
        $follower = new Follower();
        return $follower->isFollowing($targetUser->id);
    }
}
