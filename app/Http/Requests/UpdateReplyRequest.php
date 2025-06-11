<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * UpdateReplyRequest 类
 * 此请求类用于处理「更新回复」操作的表单验证逻辑。
 * 当前尚未定义验证规则，且默认拒绝所有请求。
 */
class UpdateReplyRequest extends FormRequest
{
    /**
     * 判断用户是否有权限执行该请求。
     *
     * @return bool 返回 false 表示当前所有用户都不被授权（默认禁用）
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * 获取该请求所应用的验证规则。
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 当前未定义任何验证规则
        ];
    }
}
