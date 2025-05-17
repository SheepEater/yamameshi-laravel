<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('yama_meshi_posts', function (Blueprint $table) {
            $table->json('ingredients')->nullable()->after('content');
            $table->json('packing_items')->nullable()->after('ingredients');
        });
    }
    public function down()
    {
        Schema::table('yama_meshi_posts', function (Blueprint $table) {
            $table->dropColumn(['ingredients', 'packing_items']);
        });
    }

};
