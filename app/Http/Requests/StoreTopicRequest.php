<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
{
    /**
     * 判断用户是否有权限发起此请求。
     *
     * 这里返回 true，表示所有用户都可以使用该请求类（通常权限在控制器或策略中判断）。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 获取该请求的验证规则。
     *
     * @return array<string, ValidationRule|array|string> 返回字段验证规则的数组
     */
    public function rules(): array
    {
        return [
            // 标题为必填，最少3个字符，最多30个字符
            'title' => 'required|min:3|max:30',

            // 内容为必填，最少3个字符
            'body' => 'required|min:3',

            // 分类ID为必填，且必须存在于 categories 表的 id 字段中
            'category_id' => 'required|exists:categories,id',
        ];
    }
}
