<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 除了 show 方法外，控制器中其他方法都需要用户已登录
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * 显示用户的个人资料页面
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    /**
     * 显示用户资料编辑表单
     *
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * 更新用户的个人资料
     *
     * @param UserRequest $request
     * @param ImageUploadHandler $uploader
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user): RedirectResponse
    {
        $this->authorize('update', $user);
        $data = $request->all();

        // 处理头像上传
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result === false) {
                return redirect()->back()->withErrors('头像上传失败，请重试。');
            }
            $data['avatar'] = $result['path'];
        }

        // 更新用户资料
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功。');
    }

    /**
     * 模拟登录为指定用户
     *
     * @param int $id 用户 ID
     * @param Request $request
     * @return RedirectResponse
     */
    public function impersonateUser(int $id, Request $request): RedirectResponse
    {
        if (!auth()->user() || !app()->isLocal()) {
            abort(403, '未经授权的操作。');
        }

        $user = User::find($id);

        if ($user) {
            auth()->user()->impersonate($user);
            // 获取传递的重定向地址，没有则默认跳转到首页
            $redirectTo = $request->input('redirect_to', '/');
            return redirect($redirectTo);
        }

        return redirect()->back()->with('error', '用户不存在。');
    }

    /**
     * 停止模拟登录，恢复为原用户
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function stopImpersonating(Request $request): RedirectResponse
    {
        if (!auth()->user() || !app()->isLocal()) {
            abort(403, '未经授权的操作。');
        }

        auth()->user()->leaveImpersonation();
        // 获取传递的重定向地址，没有则默认跳转到首页
        $redirectTo = $request->input('redirect_to', '/');
        return redirect($redirectTo);
    }
}
