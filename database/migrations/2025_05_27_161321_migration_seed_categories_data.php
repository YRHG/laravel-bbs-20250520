<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = [
            [
                'name' => 'シェア',
                'description' => '作品や発見をみんなと共有しましょう',
            ],
            [
                'name' => 'チュートリアル',
                'description' => '開発のコツやおすすめのパッケージなどを紹介',
            ],
            [
                'name' => 'Q&A',
                'description' => '質問や疑問を気軽に相談・解決しましょう',
            ],
            [
                'name' => 'お知らせ',
                'description' => 'サイトからのお知らせを掲載します',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('categories')->truncate();
    }
};
