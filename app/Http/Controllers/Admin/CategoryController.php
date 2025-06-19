<?php

namespace App\Http\Controllers\Admin;

class CategoryController extends Controller
{
    /**
     * 显示分类列表页面。
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 1. 从数据库获取所有分类数据
        //    这里我们假设您有一个名为 Category 的模型 (Model)
        $categories = \App\Models\Category::all();

        // 2. 加载视图文件，并把获取到的分类数据传递给视图
        //    这会去寻找 'resources/views/admin/categories/index.blade.php' 文件
        return view('admin.categories.index', compact('categories'));
    }
}
