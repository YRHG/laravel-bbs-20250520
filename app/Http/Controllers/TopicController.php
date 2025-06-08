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
     * 仅允许已登录用户创建、编辑和删除话题。
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * 显示话题列表。
     *
     * @param Request $request 请求实例，用于获取排序参数
     * @param Topic $topic 话题模型实例
     * @return View 返回话题列表视图
     */
    public function index(Request $request, Topic $topic): View
    {
        $topics = $topic->withOrder($request->order) // 使用排序参数
        ->with(['user', 'category']) // 预加载用户和分类关联数据
        ->paginate($this->perPage); // 分页获取数据

        return view('topics.index', compact('topics'));
    }

    /**
     * 显示创建新话题的表单。
     *
     * @param Topic $topic 话题模型实例
     * @return View 返回创建/编辑表单视图
     */
    public function create(Topic $topic): View
    {
        $categories = Category::all(); // 获取所有分类
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 存储新创建的话题数据。
     *
     * @param StoreTopicRequest $request 验证后的请求数据
     * @param Topic $topic 话题模型实例
     * @return RedirectResponse 重定向到话题详情页
     */
    public function store(StoreTopicRequest $request, Topic $topic): RedirectResponse
    {
        $topic->fill($request->validated()); // 填充数据
        $topic->user()->associate($request->user()); // 关联当前用户
        $topic->save(); // 保存到数据库

        return redirect()->route('topics.show', $topic)->with('success', '话题创建成功');
    }

    /**
     * 显示指定的话题内容。
     *
     * @param Topic $topic 指定话题实例（路由模型绑定）
     * @return View 返回话题详情视图
     */
    public function show(Topic $topic): View
    {
        return view('topics.show', compact('topic'));
    }

    /**
     * 显示编辑指定话题的表单。
     *
     * @param Topic $topic 指定的话题
     * @return View 返回创建/编辑表单视图
     * @throws AuthorizationException 抛出无权限异常
     */
    public function edit(Topic $topic): View
    {
        $this->authorize('update', $topic); // 权限验证：只能编辑自己的话题
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 更新指定话题的数据。
     *
     * @param UpdateTopicRequest $request 验证后的请求数据
     * @param Topic $topic 指定的话题
     * @return RedirectResponse 重定向到话题详情页
     * @throws AuthorizationException 无权限时抛出异常
     */
    public function update(UpdateTopicRequest $request, Topic $topic): RedirectResponse
    {
        $this->authorize('update', $topic);

        $topic->fill($request->validated());
        $topic->save();

        return redirect()->route('topics.show', $topic)->with('success', '话题更新成功');
    }

    /**
     * 删除指定的话题。
     *
     * @param Topic $topic 指定的话题
     * @return RedirectResponse 重定向到话题列表页
     * @throws AuthorizationException 无权限时抛出异常
     */
    public function destroy(Topic $topic): RedirectResponse
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', '话题删除成功');
    }

    /**
     * 上传话题相关的图片。
     *
     * @param Request $request 请求实例，包含上传文件
     * @param ImageUploadHandler $uploader 图片上传处理类
     * @return JsonResponse 返回上传结果的 JSON 响应
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader): JsonResponse
    {
        // 初始化返回数据，默认上传失败
        $data = [
            'success' => false,
            'message' => '上传失败！',
            'file_path' => ''
        ];

        // 判断是否上传了文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 将图片保存到本地，指定文件夹为 topics，关联当前用户，最大尺寸为 1024px
            $result = $uploader->save($file, 'topics', auth()->user()->id, 1024);

            // 上传成功，更新返回数据
            if ($result) {
                $data['success'] = true;
                $data['message'] = '上传成功！';
                $data['file_path'] = $result['path']; // 返回图片路径
            } else {
                $data['message'] = '图片格式无效或上传失败。';
            }
        }

        return response()->json($data); // 返回 JSON 响应
    }
}
