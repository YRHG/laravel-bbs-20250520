<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * 除了 'show' 方法外，控制器中的其他方法都需要用户登录后才能访问。
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * 显示用户的个人主页。
     *
     * @param User $user 用户模型实例（通过路由模型绑定获取）
     * @return View 返回用户详情视图
     */
    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    /**
     * 显示用户资料编辑表单。
     *
     * @param User $user 要编辑的用户
     * @return View 返回编辑表单视图
     * @throws AuthorizationException 如果没有权限编辑，抛出异常
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user); // 权限检查，确保用户只能编辑自己的资料
        return view('users.edit', compact('user'));
    }

    /**
     * 更新用户资料。
     *
     * @param UserRequest $request 表单验证请求类，包含用户输入
     * @param ImageUploadHandler $uploader 图片上传处理类
     * @param User $user 要更新的用户
     * @return RedirectResponse 更新成功后重定向回用户资料页
     * @throws AuthorizationException 没有权限时抛出异常
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user): RedirectResponse
    {
        $this->authorize('update', $user); // 权限检查
        $data = $request->all(); // 获取所有请求数据

        // 如果用户上传了头像
        if ($request->avatar) {
            // 保存头像到本地，目录为 avatars，最大宽度为 416px
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);

            // 如果上传失败，返回并显示错误信息
            if ($result === false) {
                return redirect()->back()->withErrors('图片上传失败，请重试。');
            }

            // 上传成功，更新头像路径
            $data['avatar'] = $result['path'];
        }

        // 更新用户数据
        $user->update($data);

        // 跳转到用户主页，并显示成功提示
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功。');
    }
}
