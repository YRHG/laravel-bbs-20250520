<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

/**
 * Horizon 服务提供者
 *
 * 用于配置 Laravel Horizon 的权限与通知等功能。
 */
class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * 启动任何应用服务。
     */
    public function boot(): void
    {
        // 调用父类的 boot 方法，完成 Horizon 默认的启动逻辑
        parent::boot();

        // 以下为 Horizon 的通知路由设置（可选）：

        // 设置接收短信通知的手机号码
        // Horizon::routeSmsNotificationsTo('15556667777');

        // 设置接收邮件通知的邮箱地址
        // Horizon::routeMailNotificationsTo('example@example.com');

        // 设置接收 Slack 通知的 webhook 地址和频道
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
    }

    /**
     * 注册 Horizon 的授权门（Gate）。
     *
     * 这个 Gate 用于判断在非本地（非 local）环境中，谁可以访问 Horizon 面板。
     */
    protected function gate(): void
    {
        Gate::define('viewHorizon', function ($user = null) {
            // 只有在这里列出的邮箱地址，才有权限访问 Horizon
            return in_array(optional($user)->email, [
                // 在此处添加你允许访问 Horizon 的用户邮箱，例如：
                // 'admin@example.com',
            ]);
        });
    }
}
