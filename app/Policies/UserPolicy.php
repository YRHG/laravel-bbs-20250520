<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * 判断用户是否可以查看所有用户模型。
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以查看指定的用户模型。
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以创建用户模型。
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以更新指定的用户模型。
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * 判断用户是否可以删除指定的用户模型。
     */
    public function delete(User $user, User $model): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以恢复被删除的用户模型。
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以永久删除指定的用户模型。
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
