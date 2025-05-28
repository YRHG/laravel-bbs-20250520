<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * 当前工厂使用的密码（缓存一次生成，提高效率）
     */
    protected static ?string $password;

    /**
     * 系统默认头像列表
     *
     * @var array|string[]
     */
    public array $avatars = [
        "/uploads/images/default-avatar/200.jpg",
        "/uploads/images/default-avatar/300.jpg",
        "/uploads/images/default-avatar/400.jpg",
        "/uploads/images/default-avatar/500.jpg",
        "/uploads/images/default-avatar/600.jpg",
    ];

    /**
     * 定义模型的默认状态
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(), // 随机用户名
            'email' => fake()->unique()->safeEmail(), // 唯一、安全的邮箱地址
            'email_verified_at' => now(), // 邮箱验证时间为当前时间
            'password' => static::$password ??= Hash::make('11111111'), // 使用固定密码加密（懒加载）
            'remember_token' => Str::random(10), // 随机记住令牌
            'introduction' => fake()->sentence(), // 简短的个人简介
            'avatar' => config('app.url') . fake()->randomElement($this->avatars), // 生成完整头像 URL
        ];
    }

    /**
     * 指定该模型的邮箱未验证状态
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null, // 设置为未验证
        ]);
    }
}
