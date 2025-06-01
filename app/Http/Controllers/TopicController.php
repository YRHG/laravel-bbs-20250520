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
     * 限制：只有已登录用户才能创建、编辑和删除话题。
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * 显示话题列表页面。
     *
     * @param Request $request 请求对象（包含排序参数等）
     * @param Topic $topic Topic 模型实例（用于链式调用）
     * @return View 返回话题列表视图
     */
    public function index(Request $request, Topic $topic): View
    {
        $topics = $topic->withOrder($request->order)  // 根据排序参数进行排序（自定义方法）
        ->with(['user', 'category'])              // 预加载用户和分类信息，避免 N+1 查询
        ->paginate($this->perPage);               // 分页显示

        return view('topics.index', compact('topics'));  // 返回视图并传入数据
    }

    /**
     * 显示创建话题的表单页面。
     *
     * @param Topic $topic 空的 Topic 模型实例（用于表单绑定）
     * @return View 返回创建/编辑表单视图
     */
    public function create(Topic $topic): View
    {
        $categories = Category::all();  // 获取所有分类用于下拉选择
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 保存新创建的话题到数据库。
     *
     * @param StoreTopicRequest $request 表单验证后的请求数据
     * @param Topic $topic 空的 Topic 模型实例
     * @return RedirectResponse 重定向到新建话题详情页
     */
    public function store(StoreTopicRequest $request, Topic $topic): RedirectResponse
    {
        $topic->fill($request->validated());           // 填充表单数据
        $topic->user()->associate($request->user());   // 关联当前登录用户
        $topic->save();                                // 保存到数据库

        return redirect()->route('topics.show', $topic)->with('success', '话题创建成功');
    }

    /**
     * 显示指定话题的详情页面。
     *
     * @param Topic $topic 当前请求的话题
     * @return View 返回话题详情视图
     */
    public function show(Topic $topic): View
    {
        return view('topics.show', compact('topic'));
    }

    /**
     * 显示编辑指定话题的表单页面。
     *
     * @param Topic $topic 要编辑的话题
     */
    public function edit(Topic $topic)
    {
        // TODO: 实现编辑逻辑
    }

    /**
     * 更新指定话题的数据到数据库。
     *
     * @param UpdateTopicRequest $request 表单验证后的请求数据
     * @param Topic $topic 要更新的话题
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        // TODO: 实现更新逻辑
    }

    /**
     * 删除指定话题。
     *
     * @param Topic $topic 要删除的话题
     */
    public function destroy(Topic $topic)
    {
        // TODO: 实现删除逻辑
    }
}
