<?php

use Illuminate\Support\Facades\Route;

/**
 * 获取当前路由名称，并将点（.）替换为中横线（-）。
 * 示例：
 *  users.index => users-index
 *  用法：
 *  <div class="{{ route_class() }}"></div>
 *  输出结果：
 *  <div class="users-index"></div>
 *
 * @return array|string
 */
function route_class(): array|string
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * 从文本中提取摘要内容。
 *
 * - 去除 HTML 标签
 * - 替换换行符为空格
 * - 限制字符串长度（默认 200）
 *
 * @param string $value 原始内容
 * @param int $length 摘要长度限制，默认 200
 * @return string 处理后的摘要文本
 */
function make_excerpt($value, $length = 200): int|string
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str()->limit($excerpt, $length);
}
