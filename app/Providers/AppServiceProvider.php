<?php

namespace App\Providers;

use App\Listeners\EmailVerified;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * 注册应用服务。
     */
    public function register(): void
    {
        //
    }

    /**
     * 启动应用服务。
     */
    public function boot(): void
    {
        // 注册事件监听器
        // 文档：https://laravel.com/docs/12.x/events
        Event::listen(
            EmailVerified::class, // 事件类，在用户完成邮箱验证后触发
        );

        // 使用 Bootstrap 样式的分页器
        Paginator::useBootstrap();
    }
}
