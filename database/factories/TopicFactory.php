<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Topic>
 */
class TopicFactory extends Factory
{
    /**
     * 定义模型的默认状态。
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 生成一个在过去三年到现在之间的随机 DateTime 对象
        $randomDateTime = $this->faker->dateTimeBetween('-3 years', 'now');

        $sentence = $this->faker->sentence();

        return [
            'title' => $sentence,
            'body' => $this->faker->paragraph(5),
            'user_id' => User::all()->random()->id, // 随机关联一个用户
            'category_id' => Category::all()->random()->id, // 随机关联一个分类
            'excerpt' => Str::limit($sentence, 50), // 摘要限制为 50 个字符
            'slug' => Str::slug($sentence), // 生成 URL 友好的 slug
            'created_at' => $randomDateTime, // 创建时间
            'updated_at' => $randomDateTime, // 更新时间
        ];
    }
}
