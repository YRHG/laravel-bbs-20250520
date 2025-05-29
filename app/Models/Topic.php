<?php

namespace App\Models;

use Database\Factories\TopicFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * 话题模型
 *
 * @property int $id 主键ID
 * @property string $title 标题
 * @property string $body 内容
 * @property int $user_id 用户ID
 * @property int $category_id 分类ID
 * @property int $view_count 浏览次数
 * @property int $reply_count 回复次数
 * @property int|null $last_reply_user_id 最后回复用户ID
 * @property int $order 排序字段
 * @property string|null $excerpt 摘要
 * @property string|null $slug URL别名
 * @property Carbon|null $created_at 创建时间
 * @property Carbon|null $updated_at 更新时间
 * @property-read Category|null $category 所属分类
 * @property-read User|null $user 所属用户
 * @method static TopicFactory factory($count = null, $state = [])
 * @method static Builder<static>|Topic newModelQuery() 创建新的模型查询
 * @method static Builder<static>|Topic newQuery() 创建新的查询构造器
 * @method static Builder<static>|Topic query() 获取查询构造器
 * @method static Builder<static>|Topic whereBody($value) 按内容过滤
 * @method static Builder<static>|Topic whereCategoryId($value) 按分类ID过滤
 * @method static Builder<static>|Topic whereCreatedAt($value) 按创建时间过滤
 * @method static Builder<static>|Topic whereExcerpt($value) 按摘要过滤
 * @method static Builder<static>|Topic whereId($value) 按ID过滤
 * @method static Builder<static>|Topic whereLastReplyUserId($value) 按最后回复用户ID过滤
 * @method static Builder<static>|Topic whereOrder($value) 按排序值过滤
 * @method static Builder<static>|Topic whereReplyCount($value) 按回复数过滤
 * @method static Builder<static>|Topic whereSlug($value) 按别名过滤
 * @method static Builder<static>|Topic whereTitle($value) 按标题过滤
 * @method static Builder<static>|Topic whereUpdatedAt($value) 按更新时间过滤
 * @method static Builder<static>|Topic whereUserId($value) 按用户ID过滤
 * @method static Builder<static>|Topic whereViewCount($value) 按浏览量过滤
 * @method static Builder<static>|Topic recent() 按创建时间排序（最近发布）
 * @method static Builder<static>|Topic recentReplied() 按更新时间排序（最近回复）
 * @method static Builder<static>|Topic withOrder(string $order) 根据排序条件排序话题
 * @mixin \Eloquent
 */
class Topic extends Model
{
    use HasFactory;

    // 可批量赋值的字段
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'category_id',
        'reply_count',
        'view_count',
        'last_reply_user_id',
        'order',
        'excerpt',
        'slug',
    ];

    /**
     * 话题所属用户。
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 话题所属分类。
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 定义一个查询作用域，用于根据指定排序方式排序话题。
     *
     * @param $query 查询构造器实例
     * @param string|null $order 排序方式（recent 或默认 recentReplied）
     * @return void
     */
    public function scopeWithOrder($query, ?string $order): void
    {
        switch ($order) {
            case 'recent':
                $query->recent($query);
                break;
            default:
                $query->recentReplied($query);
                break;
        }
    }

    /**
     * 查询作用域：按创建时间倒序排序（最新发布）。
     *
     * @param Builder $query 查询构造器
     * @return Builder
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * 查询作用域：按更新时间倒序排序（最近回复）。
     *
     * @param Builder $query 查询构造器
     * @return Builder
     */
    public function scopeRecentReplied(Builder $query): Builder
    {
        // 每当话题被回复时，框架会自动更新 updated_at 字段，
        // 因此我们可以利用这个字段按最新回复排序
        return $query->orderBy('updated_at', 'desc');
    }
}
