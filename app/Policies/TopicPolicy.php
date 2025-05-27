<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TopicPolicy
{
    /**
     * 判断用户是否可以查看所有话题。
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以查看指定的话题。
     */
    public function view(User $user, Topic $topic): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以创建话题。
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以更新指定的话题。
     */
    public function update(User $user, Topic $topic): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以删除指定的话题。
     */
    public function delete(User $user, Topic $topic): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以恢复指定被删除的话题。
     */
    public function restore(User $user, Topic $topic): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以永久删除指定的话题。
     */
    public function forceDelete(User $user, Topic $topic): bool
    {
        return false;
    }
}
