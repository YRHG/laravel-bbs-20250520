<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 分类模型 Category
 *
 * 用于表示话题所属的分类，如“技术”、“生活”、“分享”等。
 * 对应数据库中的 categories 表。
 *
 * @property int $id 主键 ID
 * @property string $name 分类名称
 * @property string|null $description 分类描述，可为空
 * @property int $post_count 分类下的帖子数量
 *
 * @method static Builder<static>|Category newModelQuery() 创建新的模型查询构造器
 * @method static Builder<static>|Category newQuery() 创建新的查询构造器
 * @method static Builder<static>|Category query() 获取当前模型的查询构造器
 * @method static Builder<static>|Category whereDescription($value) 查询描述字段
 * @method static Builder<static>|Category whereId($value) 查询 ID
 * @method static Builder<static>|Category whereName($value) 查询名称
 * @method static Builder<static>|Category wherePostCount($value) 查询帖子数量
 * @method static Builder<static>|Category recent() 自定义作用域：最近更新（如果有定义）
 *
 * @mixin \Eloquent 提示此类为 Eloquent 模型，支持智能补全
 */
class Category extends Model
{
    use HasFactory;

    /**
     * 由于当前数据表没有 created_at 和 updated_at 字段，
     * 所以要关闭时间戳自动维护功能。
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 可批量赋值的字段定义。
     * 用于允许通过 create() 或 fill() 批量写入的字段。
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
}
