<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreReplyRequest 类
 * 该请求类用于处理「创建回复」操作时的表单验证逻辑。
 *
 * @package App\Http\Requests
 * @property string $content 回复内容
 * @property int $topic_id 所属话题的 ID
 */
class StoreReplyRequest extends FormRequest
{
    /**
     * 判断用户是否有权限发起此请求。
     *
     * @return bool 返回 true 表示所有用户都允许执行此请求
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 获取此请求中应应用的验证规则。
     *
     * @return array<string, ValidationRule|array|string> 验证规则数组
     */
    public function rules(): array
    {
        return [
            'content' => 'required|min:2' // 回复内容为必填，且至少 2 个字符
        ];
    }
}
