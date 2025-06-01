<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * 显示指定分类下的话题列表。
     *
     * @param Category $category 当前请求的分类模型实例（由路由自动注入）
     * @param Request $request 请求对象，用于获取查询参数（如排序）
     * @param Topic $topic Topic 模型实例，用于链式查询（Laravel 的隐式依赖注入）
     * @return View 返回一个视图对象（topics.index），并传递话题数据
     */
    public function show(Category $category, Request $request, Topic $topic): View
    {
        $topics = $topic->withOrder($request->order)
            ->where('category_id', $category->id)
            ->with(['user', 'category'])
            ->paginate($this->perPage);

        return view('topics.index', compact('topics', 'category'));
    }
}
