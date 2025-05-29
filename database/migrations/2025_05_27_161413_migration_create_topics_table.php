<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 执行迁移操作。
     */
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id(); // 主键 ID
            $table->string('title')->index()->nullable(false)->comment('标题');
            $table->text('body')->nullable(false)->comment('内容');
            $table->unsignedInteger('user_id')->index()->nullable(false)->comment('用户 ID');
            $table->unsignedInteger('category_id')->index()->nullable(false)->comment('分类 ID');
            $table->unsignedInteger('view_count')->index()->default(0)->comment('浏览次数');
            $table->unsignedInteger('reply_count')->index()->default(0)->comment('回复次数');
            $table->unsignedInteger('last_reply_user_id')->index()->nullable()->comment('最后回复用户 ID');
            $table->unsignedInteger('order')->default(0)->comment('排序值');
            $table->text('excerpt')->nullable()->comment('内容摘要');
            $table->string('slug')->nullable()->comment('SEO 别名');
            $table->timestamps(); // 创建时间和更新时间
        });
    }

    /**
     * 回滚迁移操作。
     */
    public function down(): void
    {
        Schema::dropIfExists('topics'); // 删除 topics 表
    }
};
