<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * 显示所有分类的列表。
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建新分类的表单。
     */
    public function create()
    {
        //
    }

    /**
     * 将新创建的分类存储到数据库。
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * 显示指定的分类详情。
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * 显示编辑指定分类的表单。
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * 更新指定分类的信息。
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * 删除指定的分类。
     */
    public function destroy(Category $category)
    {
        //
    }
}
