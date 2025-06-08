<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TopicPolicy
{
    /**
     * 判断用户是否可以查看所有话题列表。
     *
     * 默认返回 false，表示不允许查看所有话题（通常用于后台权限控制）。
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以查看某个具体的话题。
     *
     * 默认返回 false，可根据需求调整（例如设置为 true 表示所有人都可以查看）。
     */
    public function view(User $user, Topic $topic): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以创建话题。
     *
     * 默认返回 false，实际项目中应返回 true 或根据用户角色判断。
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以更新某个话题。
     *
     * 只有该用户是话题作者时才允许更新。
     */
    public function update(User $user, Topic $topic): bool
    {
        return $user->isAuthorOf($topic);
    }

    /**
     * 判断用户是否可以删除某个话题。
     *
     * 仅作者本人可以删除该话题。
     */
    public function destroy(User $user, Topic $topic): bool
    {
        return $user->isAuthorOf($topic);
    }

    /**
     * 判断用户是否可以恢复已删除的话题。
     *
     * 默认不允许恢复删除的话题。
     */
    public function restore(User $user, Topic $topic): bool
    {
        return false;
    }

    /**
     * 判断用户是否可以永久删除话题（从数据库中彻底移除）。
     *
     * 默认不允许永久删除。
     */
    public function forceDelete(User $user, Topic $topic): bool
    {
        return false;
    }
}
