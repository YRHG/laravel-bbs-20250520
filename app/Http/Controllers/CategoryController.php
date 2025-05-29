<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * 显示指定分类下的主题列表。
     *
     * @param Category $category 分类模型实例
     * @param Request $request 请求实例，用于获取排序参数
     * @param Topic $topic 主题模型实例（用于调用作用域）
     * @return View 返回视图对象
     */
    public function show(Category $category, Request $request, Topic $topic): View
    {
        $topics = $topic->withOrder($request->order) // 自定义排序作用域（如最新、最热）
        ->where('category_id', $category->id)     // 只获取当前分类的主题
        ->with(['user', 'category'])              // 预加载用户和分类关联，防止 N+1 问题
        ->paginate($this->perPage);               // 分页查询

        return view('topics.index', compact('topics', 'category'));
    }
}
