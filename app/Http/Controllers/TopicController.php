<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * 只有已认证用户才能创建、编辑和删除话题。
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * 显示话题列表。
     *
     * @param Request $request
     * @param Topic $topic
     * @return View
     */
    public function index(Request $request, Topic $topic): View
    {
        $topics = $topic->withOrder($request->order)
            ->with(['user', 'category'])
            ->paginate($this->perPage);

        return view('topics.index', compact('topics'));
    }

    /**
     * 显示创建话题的表单。
     *
     * @param Topic $topic
     * @return View
     */
    public function create(Topic $topic): View
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 存储新创建的话题。
     *
     * @param StoreTopicRequest $request
     * @param Topic $topic
     * @return RedirectResponse
     */
    public function store(StoreTopicRequest $request, Topic $topic): RedirectResponse
    {
        $topic->fill($request->validated());
        $topic->user()->associate($request->user());
        $topic->save();

        return redirect()->route('topics.show', $topic)->with('success', '话题创建成功。');
    }

    /**
     * 显示指定的话题详情。
     */
    public function show(Topic $topic): View
    {
        return view('topics.show', compact('topic'));
    }

    /**
     * 显示编辑话题的表单。
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
