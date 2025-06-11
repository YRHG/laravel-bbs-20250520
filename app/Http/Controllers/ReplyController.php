<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\UpdateReplyRequest;
use App\Models\Reply;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * ReplyController 负责处理与「回复」相关的操作。
 * 包含创建与删除回复的方法。
 */
class ReplyController extends Controller
{
    /**
     * 控制器构造方法。
     * 应用 auth 中间件，确保所有方法仅限登录用户访问。
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 存储新创建的回复数据。
     *
     * @param StoreReplyRequest $request 请求验证类，包含回复的内容和话题 ID
     * @param Reply $reply 回复模型实例
     * @return RedirectResponse 返回重定向响应，跳转回所属话题页面
     */
    public function store(StoreReplyRequest $request, Reply $reply): RedirectResponse
    {
        $reply->content = $request->content;            // 设置回复内容
        $reply->user_id = auth()->id();                 // 设置当前用户为作者
        $reply->topic_id = $request->topic_id;          // 设置关联的话题 ID
        $reply->save();                                 // 保存到数据库

        return redirect()->to($reply->topic->link())    // 重定向到话题详情页
        ->with('success', '回复发布成功！');
    }

    /**
     * 删除指定的回复。
     *
     * @param Reply $reply 要删除的回复
     * @return RedirectResponse 返回重定向响应，跳转回所属话题页面
     * @throws AuthorizationException 如果用户无权限，将抛出授权异常
     */
    public function destroy(Reply $reply): RedirectResponse
    {
        $this->authorize('destroy', $reply);            // 授权验证是否可删除该回复
        $reply->delete();                               // 删除回复

        return redirect()->to($reply->topic->link())    // 重定向到话题详情页
        ->with('success', '回复已删除！');
    }
}
