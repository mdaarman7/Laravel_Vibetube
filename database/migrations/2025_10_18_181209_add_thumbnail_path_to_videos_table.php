<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_add_thumbnail_path_to_videos_table.php
    
public function up()
{
    Schema::table('videos', function (Blueprint $table) {
        $table->string('thumbnail_path')->nullable()->after('file_path');
    });
}

public function down()
{
    Schema::table('videos', function (Blueprint $table) {
        $table->dropColumn('thumbnail_path');
    });
}
};
