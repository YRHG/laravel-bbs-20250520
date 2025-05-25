<?php

use App\Http\Middleware\EnsureEmailIsVerified;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            EnsureEmailIsVerified::class,
        ]);

        // 这样注册的中间件, 可以在任何我们想要用到该中间件的地方使用
        // 和 auth、guest 一样
        // $middleware->alias([
        //     'verified' => EnsureEmailIsVerified::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
