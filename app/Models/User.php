<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * 用户模型
 *
 * @property int $id 用户ID
 * @property string $name 用户名
 * @property string $email 邮箱地址
 * @property Carbon|null $email_verified_at 邮箱验证时间
 * @property string $password 登录密码
 * @property string|null $remember_token 记住我 Token
 * @property Carbon|null $created_at 创建时间
 * @property Carbon|null $updated_at 更新时间
 * @property string|null $avatar 头像地址
 * @property string|null $introduction 个人简介
 *
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications 通知集合
 * @property-read int|null $notifications_count 通知数量
 *
 * @method static UserFactory factory($count = null, $state = []) 工厂方法
 * @method static Builder<static>|User newModelQuery() 创建新的模型查询
 * @method static Builder<static>|User newQuery() 创建新的查询构造器
 * @method static Builder<static>|User query() 获取查询构造器
 * @method static Builder<static>|User whereCreatedAt($value) 按创建时间过滤
 * @method static Builder<static>|User whereEmail($value) 按邮箱过滤
 * @method static Builder<static>|User whereEmailVerifiedAt($value) 按邮箱验证时间过滤
 * @method static Builder<static>|User whereId($value) 按ID过滤
 * @method static Builder<static>|User whereName($value) 按用户名过滤
 * @method static Builder<static>|User wherePassword($value) 按密码过滤
 * @method static Builder<static>|User whereRememberToken($value) 按记住我Token过滤
 * @method static Builder<static>|User whereUpdatedAt($value) 按更新时间过滤
 * @method static Builder<static>|User whereAvatar($value) 按头像地址过滤
 * @method static Builder<static>|User whereIntroduction($value) 按个人简介过滤
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** 使用用户工厂类 */
    use HasFactory, Notifiable, MustVerifyEmailTrait;

    /**
     * 可被批量赋值的字段。
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'introduction',
    ];

    /**
     * 序列化时需要隐藏的字段。
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 字段类型转换规则。
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // 将邮箱验证时间转为 Carbon 实例
            'password' => 'hashed',            // 自动加密密码
        ];
    }
}
