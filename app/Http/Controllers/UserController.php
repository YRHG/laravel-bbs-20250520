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
     * 除了 show 方法外，控制器中的其他方法都需要登录权限。
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * 显示用户个人主页。
     *
     * @param User $user 用户模型实例
     * @return View 返回视图
     */
    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    /**
     * 显示编辑用户资料的表单。
     *
     * @param User $user 用户模型实例
     * @return View 返回视图
     * @throws AuthorizationException 授权失败时抛出异常
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user); // 权限检查
        return view('users.edit', compact('user'));
    }

    /**
     * 更新用户资料。
     *
     * @param UserRequest $request 表单验证请求
     * @param ImageUploadHandler $uploader 图片上传处理类
     * @param User $user 用户模型实例
     * @return RedirectResponse 重定向响应
     * @throws AuthorizationException 授权失败时抛出异常
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user): RedirectResponse
    {
        $this->authorize('update', $user); // 权限检查
        $data = $request->all();

        // 如果上传了头像图片
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result === false) {
                return redirect()->back()->withErrors('图片上传失败，请重试。');
            }
            $data['avatar'] = $result['path'];
        }

        $user->update($data); // 更新用户资料
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功。');
    }
}
