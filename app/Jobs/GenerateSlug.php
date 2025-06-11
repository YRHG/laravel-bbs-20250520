<?php

namespace App\Jobs;

use App\Models\Topic;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * GenerateSlug 队列任务
 * 用于为话题生成 slug（SEO 友好的 URL 字符串）
 */
class GenerateSlug implements ShouldQueue
{
    use Queueable;

    protected Topic $topic;

    /**
     * 创建新的任务实例。
     *
     * @param Topic $topic 要处理的话题模型
     */
    public function __construct(Topic $topic)
    {
        // 队列任务构造器中接收 Eloquent 模型，会自动序列化模型的 ID（避免序列化整个模型）
        $this->topic = $topic;
    }

    /**
     * 执行任务逻辑。
     *
     * @return void
     */
    public function handle(): void
    {
        // 使用 Laravel 辅助函数生成 slug：
        // 替换标题中的空格为连字符，并进行 URL 编码
        $slug = rawurlencode(Str::replace(' ', '-', $this->topic->title));

        // 使用 DB 查询构造器更新数据库中对应话题的 slug 字段
        DB::table('topics')->where('id', $this->topic->id)->update(['slug' => $slug]);
    }
}
