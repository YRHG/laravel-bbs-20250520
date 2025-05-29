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
        // 生成一个在过去三年到现在之间的随机创建时间
        $createdAt = $this->faker->dateTimeBetween('-3 years', 'now');

        // 生成一个更新时间，确保在创建时间之后且不超过现在
        $updatedAt = $this->faker->dateTimeBetween($createdAt, 'now');

        // 生成一个随机的句子作为标题
        $sentence = $this->faker->sentence();

        return [
            'title' => $sentence,
            'body' => $this->faker->paragraph(5), // 随机生成五段正文内容
            'user_id' => User::all()->random()->id, // 随机选择一个已有用户
            'category_id' => Category::all()->random()->id, // 随机选择一个已有分类
            'excerpt' => Str::limit($sentence, 50), // 生成摘要（限制长度为50）
            'slug' => Str::slug($sentence), // 将标题转为 URL 友好的别名
            'created_at' => $createdAt, // 创建时间
            'updated_at' => $updatedAt, // 更新时间
        ];
    }
}
