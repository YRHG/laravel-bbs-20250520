<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * 显示某个分类下的话题列表。
     *
     * @param Category $category 分类模型实例
     * @param Request $request 请求实例，用于获取请求参数（如排序方式）
     * @param Topic $topic 话题模型实例
     * @return View 返回一个视图，显示分类下的话题列表
     */
    public function show(Category $category, Request $request, Topic $topic): View
    {
        // 根据请求中的排序参数获取话题列表，筛选当前分类下的内容，并预加载用户和分类关系
        $topics = $topic->withOrder($request->order)
            ->where('category_id', $category->id)
            ->with(['user', 'category'])
            ->paginate($this->perPage); // 分页显示话题

        // 返回话题列表视图，并传递话题和分类数据
        return view('topics.index', compact('topics', 'category'));
    }
}
