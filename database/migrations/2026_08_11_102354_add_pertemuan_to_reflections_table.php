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
        Schema::table('reflections', function (Blueprint $table) {
            $table->unsignedTinyInteger('pertemuan')->default(1)->after('user_id');
            $table->unique(['user_id', 'pertemuan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reflections', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'pertemuan']);
            $table->dropColumn('pertemuan');
        });
    }
};
