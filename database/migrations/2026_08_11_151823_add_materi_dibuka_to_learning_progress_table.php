<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('learning_progress', function (Blueprint $table) {
            $table->boolean('materi_dibuka_1')->default(false)->after('fase5');
            $table->boolean('materi_dibuka_2')->default(false)->after('p2_fase5');
            $table->boolean('materi_dibuka_3')->default(false)->after('p3_fase5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_progress', function (Blueprint $table) {
            $table->dropColumn(['materi_dibuka_1', 'materi_dibuka_2', 'materi_dibuka_3']);
        });
    }
};
