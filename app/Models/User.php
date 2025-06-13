<?php

namespace App\Models;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 *
 *
 * @property int $id 用户 ID
 * @property string $name 用户名
 * @property string $email 邮箱
 * @property Carbon|null $email_verified_at 邮箱验证时间
 * @property string $password 密码
 * @property string|null $remember_token 记住我 Token
 * @property Carbon|null $created_at 创建时间
 * @property Carbon|null $updated_at 更新时间
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications 用户通知集合
 * @property-read int|null $notifications_count 通知数量
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereName($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @property string|null $avatar 头像
 * @property string|null $introduction 个人简介
 * @method static Builder<static>|User whereAvatar($value)
 * @method static Builder<static>|User whereIntroduction($value)
 * @property-read Collection<int, Topic> $topics 用户发布的话题集合
 * @property-read int|null $topics_count 用户话题数量
 * @property-read Collection<int, Reply> $replies 用户的回复集合
 * @property-read int|null $replies_count 回复数量
 * @property int $notification_count 未读通知数量
 * @method static Builder<static>|User whereNotificationCount($value)
 * @property-read Collection<int, Permission> $permissions 用户权限集合
 * @property-read int|null $permissions_count 权限数量
 * @property-read Collection<int, Role> $roles 用户角色集合
 * @property-read int|null $roles_count 角色数量
 * @method static Builder<static>|User permission($permissions, $without = false)
 * @method static Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static Builder<static>|User withoutPermission($permissions)
 * @method static Builder<static>|User withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, MustVerifyEmailTrait, HasRoles, Impersonate;

    use Notifiable {
        notify as protected laravelNotify;
    }

    /**
     * 重写 notify 方法，用于处理通知逻辑
     *
     * @param $instance 通知实例
     * @return void
     */
    public function notify($instance): void
    {
        // 如果是当前用户，且不是邮箱验证通知，则不执行通知
        if ($this->id === auth()->id() && get_class($instance) !== VerifyEmail::class) {
            return;
        }

        // 仅当通知支持 toDatabase 方法时才计数（即为数据库通知），
        // Email 或其他方式通知不增加计数
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }

    /**
     * 可批量赋值的字段
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
     * 序列化时需要隐藏的字段
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 属性类型转换
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * 用户拥有多个话题
     *
     * @return HasMany
     */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * 判断用户是否为模型的作者
     *
     * @param $model
     * @return bool
     */
    public function isAuthorOf($model): bool
    {
        return $this->id === $model->user_id;
    }

    /**
     * 用户拥有多个回复
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * 标记所有通知为已读
     *
     * @return void
     */
    public function markAsRead(): void
    {
        $this->notification_count = 0;
        $this->save();
        $this->notifications->markAsRead();
    }
}
