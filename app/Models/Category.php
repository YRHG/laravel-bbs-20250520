<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 分类模型
 *
 * @property int $id 主键ID
 * @property string $name 名称
 * @property string|null $description 描述
 * @property int $post_count 帖子数量
 * @method static Builder<static>|Category newModelQuery() 创建一个新的模型查询实例
 * @method static Builder<static>|Category newQuery() 创建一个新的查询构造器
 * @method static Builder<static>|Category query() 获取查询构造器
 * @method static Builder<static>|Category whereDescription($value) 根据描述过滤
 * @method static Builder<static>|Category whereId($value) 根据ID过滤
 * @method static Builder<static>|Category whereName($value) 根据名称过滤
 * @method static Builder<static>|Category wherePostCount($value) 根据帖子数量过滤
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    /**
     * 当前模型对应的表中没有 created_at 和 updated_at 字段，
     * 因此需要将 $timestamps 设置为 false，
     * 否则 Laravel 默认会自动维护这两个时间戳字段。
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 允许批量赋值的字段。
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
}
