<?php

namespace App\Providers;

use App\Listeners\EmailVerified;
use App\Models\Reply;
use App\Models\Topic;
use App\Observers\ReplyObserver;
use App\Observers\TopicObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

/**
 * AppServiceProvider 是应用程序的主要服务提供者之一，
 * 用于注册和引导（boot）各种应用服务。
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * 注册应用程序中的服务。
     * 此方法在服务容器注册所有绑定之前执行。
     */
    public function register(): void
    {
        // 当前未注册额外服务
    }

    /**
     * 启动应用程序服务。
     * 此方法在所有服务提供者注册之后执行。
     */
    public function boot(): void
    {
        // 注册事件监听器
        // 文档：https://laravel.com/docs/12.x/events
        Event::listen(
            EmailVerified::class, // 当用户完成邮箱验证时触发的事件
        );

        // 注册 Eloquent 模型观察者
        // 文档：https://laravel.com/docs/12.x/eloquent#model-observers
        Topic::observe(TopicObserver::class); // 监听 Topic 模型的事件（创建、更新、删除等）
        Reply::observe(ReplyObserver::class); // 监听 Reply 模型的事件

        // 启用 Bootstrap 风格的分页样式（用于 Laravel 分页组件）
        Paginator::useBootstrap();
    }
}
