<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * 构造方法：仅允许已登录用户执行创建、编辑、删除操作。
     * 访客用户只允许查看列表和详情页。
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * 显示话题列表。
     *
     * @param Request $request 请求对象，用于获取排序参数
     * @param Topic $topic 话题模型
     * @return View 返回视图
     */
    public function index(Request $request, Topic $topic): View
    {
        $topics = $topic->withOrder($request->order) // 自定义排序（按最新/热门等）
        ->with(['user', 'category'])             // 预加载用户和分类数据
        ->paginate($this->perPage);              // 分页处理

        return view('topics.index', compact('topics'));
    }

    /**
     * 显示创建新话题的表单页面。
     *
     * @param Topic $topic 空话题模型，用于表单绑定
     * @return View 返回视图
     */
    public function create(Topic $topic): View
    {
        $categories = Category::all(); // 获取所有分类
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 存储新创建的话题。
     *
     * @param StoreTopicRequest $request 表单验证请求
     * @param Topic $topic 空话题模型实例
     * @return RedirectResponse 重定向到话题详情页
     */
    public function store(StoreTopicRequest $request, Topic $topic): RedirectResponse
    {
        $topic->fill($request->validated());              // 填充字段
        $topic->user()->associate($request->user());      // 关联用户
        $topic->save();                                   // 保存到数据库

        return redirect()->to($topic->link())->with('success', '话题创建成功。');
    }

    /**
     * 显示话题详情页。
     * 如果 slug 不匹配则 301 重定向到正确地址。
     *
     * @param Topic $topic 当前话题模型
     * @param ?string $slug URL 中的 slug，可选
     * @return View|RedirectResponse 返回视图或重定向
     */
    public function show(Topic $topic, $slug = null): View|RedirectResponse
    {
        if (!empty($topic->slug) && $topic->slug != rawurlencode($slug)) {
            return redirect($topic->link(), 301); // 永久重定向到正确链接
        }

        return view('topics.show', compact('topic'));
    }

    /**
     * 显示编辑话题的表单页面。
     *
     * @param Topic $topic 要编辑的话题
     * @return View 返回视图
     * @throws AuthorizationException 未授权用户会抛出异常
     */
    public function edit(Topic $topic): View
    {
        $this->authorize('update', $topic); // 授权检查
        $categories = Category::all();      // 获取分类
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 更新已有话题的内容。
     *
     * @param UpdateTopicRequest $request 验证请求
     * @param Topic $topic 当前话题
     * @return RedirectResponse 返回重定向
     * @throws AuthorizationException 未授权用户会抛出异常
     */
    public function update(UpdateTopicRequest $request, Topic $topic): RedirectResponse
    {
        $this->authorize('update', $topic);

        $topic->fill($request->validated());
        $topic->save();

        return redirect()->to($topic->link())->with('success', '话题更新成功。');
    }

    /**
     * 删除指定话题。
     *
     * @param Topic $topic 要删除的话题
     * @return RedirectResponse 返回重定向到话题列表页
     * @throws AuthorizationException 未授权用户会抛出异常
     */
    public function destroy(Topic $topic): RedirectResponse
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', '话题删除成功。');
    }

    /**
     * 上传话题配图（用于编辑器中的图片上传）。
     *
     * @param Request $request 请求对象，包含上传的文件
     * @param ImageUploadHandler $uploader 图片上传处理器
     * @return JsonResponse 返回 JSON 格式的上传结果
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader): JsonResponse
    {
        // 初始化返回数据，默认上传失败
        $data = [
            'success' => false,
            'message' => '上传失败！',
            'file_path' => ''
        ];

        // 判断是否上传了文件
        if ($file = $request->upload_file) {
            // 调用上传处理器，限制宽度为 1024 像素
            $result = $uploader->save($file, 'topics', auth()->user()->id, 1024);

            // 如果上传成功
            if ($result) {
                $data['success'] = true;
                $data['message'] = '上传成功！';
                $data['file_path'] = $result['path']; // 返回图片路径
            } else {
                $data['message'] = '图片格式无效或上传失败。';
            }
        }

        return response()->json($data);
    }
}
