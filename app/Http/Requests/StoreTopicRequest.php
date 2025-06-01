<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
{
    /**
     * 判断用户是否有权限发出此请求。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 获取应用于此请求的验证规则。
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:30', // 标题为必填，长度在3到30之间
            'body' => 'required|min:3',          // 内容为必填，最少3个字符
            'category_id' => 'required|exists:categories,id', // 分类为必填，且必须存在于 categories 表中
        ];
    }
}
