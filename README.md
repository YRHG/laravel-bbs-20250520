# ☯️ {{ app.name }}

<p align="center">
  <img src="https://img.shields.io/badge/laravel-12.x-orange.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/php-8.4%2B-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/license-MIT-green.svg" alt="License">
  </p>

> `{{ app.name }}` 是一个基于 Laravel Framework 构建的现代化、功能强大的论坛（BBS）系统。它深度整合了多种流行技术，旨在提供一个高性能、高扩展性的社区解决方案。

---

## 📦 技术栈 (Technology Stack)

- **后端框架**: Laravel Framework 12.14.1
- **编程语言**: PHP 8.4+
- **数据库**: MySQL 8.0+ / MariaDB 10.6+
- **核心依赖**: Composer for PHP
- **前端构建**: Vite
- **前端依赖**: Yarn / npm
- **前端样式**: Bootstrap ^5.3.6 & Tailwind CSS ^3.4.1 混合方案
- **缓存/队列**: Redis, Horizon 可视化队列管理
- **核心功能**: 中间件, 事件监听, 任务调度, 消息队列等
- **图标库**: FontAwesome

---

## 🚀 安装与配置 (Installation & Setup)

请遵循以下步骤，在您的本地环境中快速部署本项目。

1.  **克隆代码仓库**
    ```bash
    git clone git@github.com:LuStormstout/laravel-bbs-202503.git
    cd laravel-bbs-202503
    ```

2.  **安装依赖**
    ```bash
    # 安装 PHP 依赖包
    composer install

    # 安装 Node.js 依赖包
    yarn install
    ```

3.  **配置环境**
    ```bash
    # 1. 复制环境文件
    cp .env.example .env

    # 2. 生成应用密钥
    php artisan key:generate
    ```
    > **重要**: 请手动打开 `.env` 文件，配置您的数据库连接信息 (`DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) 以及 Redis 连接等。

4.  **数据库初始化**
    ```bash
    # 运行数据表迁移并填充初始数据
    php artisan migrate --seed
    ```

5.  **启动服务**
    ```bash
    # 启动 PHP 内置服务器 (后端)
    php artisan serve

    # 启动 Vite 开发服务器 (前端)
    yarn dev
    ```
    🎉 恭喜！现在项目已在本地成功运行。

---

## 📂 核心目录结构 (Directory Structure)

- `app/` - 应用核心逻辑 (模型、控制器、服务等)。
- `config/` - 应用的所有配置文件。
- `database/` - 数据库迁移、数据工厂和数据填充器。
- `public/` - Web 服务器的根目录，前端资源的入口。
- `resources/` - 未编译的前端资源 (Blade 视图, Sass, JavaScript)。
- `routes/` - 应用的所有路由定义。
- `storage/` - 编译后的 Blade 模板、缓存、日志等。
- `tests/` - 自动化测试文件。

---

## 📅 定时任务 (Scheduler)

本项目使用 Laravel 任务调度来执行周期性任务 (例如：每日数据统计)。为使其正常工作，您需要在服务器上添加一条 Cron 记录。

1.  打开 `crontab` 进行编辑：
    ```bash
    crontab -e
    ```

2.  添加以下行，并确保项目路径正确无误：
    ```bash
    * * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
    ```

---

## 🌐 Nginx 生产环境配置示例

```nginx
server {
    listen 80;
    server_name your-domain.com; # 替换成您的域名

    root /path/to/your/project/public; # 替换成您项目的 public 目录路径
    index index.php index.html;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?<span class="math-inline">que<1\>ry\_string;
\}
location \= /favicon\.ico \{ access\_log off; log\_not\_found off; \}
location \= /robots\.txt  \{ access\_log off; log\_not\_found off; \}
location \~ \\\.php</span> {
        include fastcgi_params;
        # 根据您的 PHP-FPM 配置，路径可能不同
        fastcgi_pass unix:/run/php/php8.4-fpm.sock; 
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
