<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Topic;
use Illuminate\Contracts\View\View;

class TopicsController extends Controller
{
    /**
     * 显示资源列表。
     */
    public function index(): View
    {
        $topics = Topic::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('topics.index', compact('topics'));
    }

    /**
     * 显示创建新资源的表单。
     */
    public function create()
    {
        //
    }

    /**
     * 将新创建的资源存储到数据库中。
     */
    public function store(StoreTopicRequest $request)
    {
        //
    }

    /**
     * 显示指定资源的详细信息。
     */
    public function show(Topic $topic): View
    {
        return view('topics.show', compact('topic'));
    }

    /**
     * 显示编辑指定资源的表单。
     */
    public function edit(Topic $topic)
    {
        //
    }

    /**
     * 更新指定资源的信息。
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        //
    }

    /**
     * 删除指定的资源。
     */
    public function destroy(Topic $topic)
    {
        //
    }
}
