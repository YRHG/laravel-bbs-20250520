<?php

namespace App\Observers;

use App\Models\Topic;

class TopicObserver
{
    /**
     * 当话题被创建或更新时，从内容生成摘要。
     *
     * @param Topic $topic
     * @return void
     */
    public function saving(Topic $topic): void
    {
        $topic->excerpt = make_excerpt($topic->body);
    }
}
