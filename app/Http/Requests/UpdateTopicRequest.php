<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicRequest extends FormRequest
{
    /**
     * 判断用户是否有权限发起此请求。
     *
     * 这里返回 true，表示所有用户都可以使用该请求类（具体权限通常在控制器中通过策略进行检查）。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 获取此请求对应的验证规则。
     *
     * @return array<string, ValidationRule|array|string> 返回用于验证输入数据的规则数组
     */
    public function rules(): array
    {
        return [
            // 标题为必填，长度必须在 3 到 30 个字符之间
            'title' => 'required|min:3|max:30',

            // 内容为必填，长度至少为 3 个字符
            'body' => 'required|min:3',

            // 分类 ID 为必填，且必须存在于 categories 表的 id 字段中
            'category_id' => 'required|exists:categories,id',
        ];
    }
}
