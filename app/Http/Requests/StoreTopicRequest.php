<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
{
    /**
     * 确定用户是否有权限发起此请求。
     *
     * @return bool 返回 true 表示所有用户都允许通过验证（一般在创建话题时已登录）
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 获取应用于该请求的验证规则。
     *
     * @return array<string, ValidationRule|array|string> 返回字段的验证规则数组
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:30',               // 标题：必填，长度 3～30 字符
            'body' => 'required|min:3',                       // 内容：必填，最少 3 字符
            'category_id' => 'required|exists:categories,id', // 分类 ID：必填，且必须存在于 categories 表中
        ];
    }
}
