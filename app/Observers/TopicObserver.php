<?php

namespace App\Observers;

use App\Models\Topic;

class TopicObserver
{
    /**
     * 当话题正在创建或更新时，自动生成摘要，并处理内容与 slug。
     *
     * @param Topic $topic 当前正在保存的话题实例
     * @return void
     */
    public function saving(Topic $topic): void
    {
        // 清理话题内容，去除不安全的 HTML 标签（使用 user_topic_body 策略）
        $topic->body = clean($topic->body, 'user_topic_body');

        // 根据内容生成摘要（一般截取前一部分文字）
        $topic->excerpt = make_excerpt($topic->body);

        // 如果 slug 字段为空，则根据标题生成 slug
        // 这里采用日本公司常见的做法：对标题进行 URL 编码
        if (!$topic->slug) {
            $topic->slug = rawurlencode($topic->title);
        }
    }
}
