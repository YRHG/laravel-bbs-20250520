<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Topic;

class TopicsController extends Controller
{
    /**
     * 显示话题列表。
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建新话题的表单。
     */
    public function create()
    {
        //
    }

    /**
     * 将新创建的话题存储到数据库。
     */
    public function store(StoreTopicRequest $request)
    {
        //
    }

    /**
     * 显示指定的话题详情。
     */
    public function show(Topic $topic)
    {
        //
    }

    /**
     * 显示编辑指定话题的表单。
     */
    public function edit(Topic $topic)
    {
        //
    }

    /**
     * 更新指定的话题。
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        //
    }

    /**
     * 删除指定的话题。
     */
    public function destroy(Topic $topic)
    {
        //
    }
}
