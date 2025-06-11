<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * TopicPolicy 话题授权策略类
 *
 * 用于定义用户对话题（Topic）模型的各项操作权限。
 */
class TopicPolicy
{
    /**
     * 判断用户是否有权限查看所有话题列表。
     *
     * @param User $user 当前登录用户
     * @return bool 返回 false 表示不允许
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * 判断用户是否有权限查看指定话题。
     *
     * @param User $user 当前登录用户
     * @param Topic $topic 要查看的话题
     * @return bool 返回 false 表示不允许
     */
    public function view(User $user, Topic $topic): bool
    {
        return false;
    }

    /**
     * 判断用户是否有权限创建话题。
     *
     * @param User $user 当前登录用户
     * @return bool 返回 false 表示不允许
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * 判断用户是否有权限更新指定话题。
     *
     * @param User $user 当前登录用户
     * @param Topic $topic 要更新的话题
     * @return bool 若用户是话题作者则返回 true，否则返回 false
     */
    public function update(User $user, Topic $topic): bool
    {
        return $user->isAuthorOf($topic);
    }

    /**
     * 判断用户是否有权限删除指定话题。
     *
     * @param User $user 当前登录用户
     * @param Topic $topic 要删除的话题
     * @return bool 若用户是话题作者则返回 true，否则返回 false
     */
    public function destroy(User $user, Topic $topic): bool
    {
        return $user->isAuthorOf($topic);
    }

    /**
     * 判断用户是否有权限恢复被删除的话题。
     *
     * @param User $user 当前登录用户
     * @param Topic $topic 要恢复的话题
     * @return bool 返回 false 表示不允许
     */
    public function restore(User $user, Topic $topic): bool
    {
        return false;
    }

    /**
     * 判断用户是否有权限永久删除话题。
     *
     * @param User $user 当前登录用户
     * @param Topic $topic 要永久删除的话题
     * @return bool 返回 false 表示不允许
     */
    public function forceDelete(User $user, Topic $topic): bool
    {
        return false;
    }
}
