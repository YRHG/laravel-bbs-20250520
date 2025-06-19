<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * 除了查看和显示，其他操作都要求用户登录。
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * 显示话题列表页面。
     *
     * @param Request $request 请求对象
     * @param Topic $topic 话题模型实例
     * @param User $user 用户模型实例
     * @param Link $link 链接模型实例
     * @return View 返回视图
     */
    public function index(Request $request, Topic $topic, User $user, Link $link): View
    {
        $topics = $topic->withOrder($request->order)
            ->with(['user', 'category'])
            ->paginate($this->perPage);

        $active_users = $user->getActiveUsers();
        $links = $link->getAllCached();

        return view('topics.index', compact('topics', 'active_users', 'links'));
    }

    /**
     * 显示创建话题的表单页面。
     *
     * @param Topic $topic 话题模型实例
     * @return View 返回视图
     */
    public function create(Topic $topic): View
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 保存新创建的话题数据。
     *
     * @param StoreTopicRequest $request 表单验证请求
     * @param Topic $topic 话题模型实例
     * @return RedirectResponse 重定向响应
     */
    public function store(StoreTopicRequest $request, Topic $topic): RedirectResponse
    {
        $topic->fill($request->validated());
        $topic->user()->associate($request->user());
        $topic->save();

        return redirect()->to($topic->link())->with('success', '话题创建成功。');
    }

    /**
     * 显示某个具体话题的详细内容。
     * 如果话题存在 slug，但与请求中的不一致，则重定向到正确链接。
     *
     * @param Topic $topic 话题模型实例
     * @param string|null $slug 可选的 URL slug
     * @return View|RedirectResponse 返回视图或重定向
     */
    public function show(Topic $topic, $slug = null): View|RedirectResponse
    {
        if (!empty($topic->slug) && $topic->slug != rawurlencode($slug)) {
            return redirect($topic->link(), 301);
        }

        return view('topics.show', compact('topic'));
    }

    /**
     * 显示编辑话题的表单页面。
     *
     * @param Topic $topic 话题模型实例
     * @return View 返回视图
     * @throws AuthorizationException 未授权时抛出
     */
    public function edit(Topic $topic): View
    {
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 更新指定话题的数据。
     *
     * @param UpdateTopicRequest $request 表单验证请求
     * @param Topic $topic 话题模型实例
     * @return RedirectResponse 重定向响应
     * @throws AuthorizationException 未授权时抛出
     */
    public function update(UpdateTopicRequest $request, Topic $topic): RedirectResponse
    {
        $this->authorize('update', $topic);

        $topic->fill($request->validated());
        $topic->save();

        return redirect()->to($topic->link())->with('success', '话题更新成功。');
    }

    /**
     * 删除指定的话题。
     *
     * @param Topic $topic 话题模型实例
     * @return RedirectResponse 重定向响应
     * @throws AuthorizationException 未授权时抛出
     */
    public function destroy(Topic $topic): RedirectResponse
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', '话题删除成功。');
    }

    /**
     * 上传话题相关图片。
     *
     * @param Request $request 请求对象
     * @param ImageUploadHandler $uploader 图片上传处理器
     * @return JsonResponse JSON 响应
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader): JsonResponse
    {
        // 初始化返回数据，默认上传失败
        $data = [
            'success' => false,
            'message' => '上传失败！',
            'file_path' => ''
        ];

        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地，限制最大宽度为 1024
            $result = $uploader->save($file, 'topics', auth()->user()->id, 1024);

            // 如果上传成功
            if ($result) {
                $data['success'] = true;
                $data['message'] = '上传成功！';
                $data['file_path'] = $result['path']; // 返回图片的存储路径
            } else {
                $data['message'] = '图片格式不正确或上传失败。';
            }
        }
        return response()->json($data);
    }
}
