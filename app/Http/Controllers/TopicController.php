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
     * 显示创建新话题的表单。
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

        return redirect()->to($topic->link())->with('success', '话题创建成功。');
    }

    /**
     * 显示指定话题。
     * 如果话题的 slug 不匹配请求的 slug，则 301 重定向到正确的链接。
     *
     * @param Topic $topic
     * @param ?null $slug
     * @return View|RedirectResponse
     */
    public function show(Topic $topic, $slug = null): View|RedirectResponse
    {
        if (!empty($topic->slug) && $topic->slug != rawurlencode($slug)) {
            return redirect($topic->link(), 301);
        }

        return view('topics.show', compact('topic'));
    }

    /**
     * 显示编辑指定话题的表单。
     *
     * @param Topic $topic
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Topic $topic): View
    {
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    /**
     * 更新指定话题。
     *
     * @param UpdateTopicRequest $request
     * @param Topic $topic
     * @return RedirectResponse
     * @throws AuthorizationException
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
     * @param Topic $topic
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Topic $topic): RedirectResponse
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', '话题删除成功。');
    }

    /**
     * 处理话题图片上传。
     *
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return JsonResponse
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
            // 保存图片到本地
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
