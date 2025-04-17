<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('yama_meshi_posts', function (Blueprint $table) {
            $table->string('place')->nullable();       // 行った場所
            $table->string('food')->nullable();        // 食べたもの
            $table->date('date')->nullable();          // 日付
            $table->json('image_paths')->nullable();   // 複数画像のパス（JSON形式）
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('yama_meshi_posts', function (Blueprint $table) {
            $table->dropColumn(['place', 'food', 'date', 'image_paths']);
        });
    }
};
