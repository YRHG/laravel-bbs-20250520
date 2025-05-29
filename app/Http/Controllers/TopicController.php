<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Topic;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * 显示主题列表。
     */
    public function index(Request $request, Topic $topic): View
    {
        $topics = $topic->withOrder($request->order) // 根据请求参数排序
        ->with(['user', 'category'])             // 预加载用户和分类，避免 N+1 问题
        ->paginate($this->perPage);              // 分页查询

        return view('topics.index', compact('topics'));
    }

    /**
     * 显示创建新主题的表单。
     */
    public function create()
    {
        //
    }

    /**
     * 将新创建的主题保存到数据库。
     */
    public function store(StoreTopicRequest $request)
    {
        //
    }

    /**
     * 显示指定的主题详情。
     */
    public function show(Topic $topic): View
    {
        return view('topics.show', compact('topic'));
    }

    /**
     * 显示编辑指定主题的表单。
     */
    public function edit(Topic $topic)
    {
        //
    }

    /**
     * 更新指定的主题数据。
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        //
    }

    /**
     * 删除指定的主题。
     */
    public function destroy(Topic $topic)
    {
        //
    }
}
