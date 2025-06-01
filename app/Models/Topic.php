<?php

namespace App\Models;

use App\Observers\TopicObserver;
use Database\Factories\TopicFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * 话题模型
 *
 * @property int $id
 * @property string $title 标题
 * @property string $body 内容
 * @property int $user_id 用户ID
 * @property int $category_id 分类ID
 * @property int $view_count 浏览次数
 * @property int $reply_count 回复次数
 * @property int|null $last_reply_user_id 最后回复用户ID
 * @property int $order 排序
 * @property string|null $excerpt 摘要
 * @property string|null $slug 别名（SEO）
 * @property Carbon|null $created_at 创建时间
 * @property Carbon|null $updated_at 更新时间
 * @property-read Category|null $category 关联的分类
 * @property-read User|null $user 关联的用户
 * @method static TopicFactory factory($count = null, $state = [])
 * @method static Builder<static>|Topic newModelQuery()
 * @method static Builder<static>|Topic newQuery()
 * @method static Builder<static>|Topic query()
 * @method static Builder<static>|Topic whereBody($value)
 * @method static Builder<static>|Topic whereCategoryId($value)
 * @method static Builder<static>|Topic whereCreatedAt($value)
 * @method static Builder<static>|Topic whereExcerpt($value)
 * @method static Builder<static>|Topic whereId($value)
 * @method static Builder<static>|Topic whereLastReplyUserId($value)
 * @method static Builder<static>|Topic whereOrder($value)
 * @method static Builder<static>|Topic whereReplyCount($value)
 * @method static Builder<static>|Topic whereSlug($value)
 * @method static Builder<static>|Topic whereTitle($value)
 * @method static Builder<static>|Topic whereUpdatedAt($value)
 * @method static Builder<static>|Topic whereUserId($value)
 * @method static Builder<static>|Topic whereViewCount($value)
 * @method static Builder<static>|Topic recent() 按创建时间排序
 * @method static Builder<static>|Topic recentReplied() 按最后回复时间排序
 * @method static Builder<static>|Topic withOrder(string $order) 根据传入的排序条件排序
 * @mixin \Eloquent
 */
#[ObservedBy(TopicObserver::class)]
class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    /**
     * 话题属于一个用户。
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 话题属于一个分类。
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 根据传入的排序参数进行排序。
     *
     * @param $query
     * @param string|null $order 排序参数，如 recent 或 recentReplied
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
     * 按创建时间倒序排序话题。
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * 按最后回复时间倒序排序话题。
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeRecentReplied(Builder $query): Builder
    {
        // 当话题有新回复时，我们会更新 reply_count，
        // 同时 updated_at 时间戳也会被自动更新
        return $query->orderBy('updated_at', 'desc');
    }
}
