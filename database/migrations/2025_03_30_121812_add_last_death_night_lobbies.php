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
        Schema::table('lobbies', function (Blueprint $table) {
            $table->integer('last_death_night')->default(0)->after('day_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lobbies', function (Blueprint $table) {
            $table->dropColumn('last_death_night');
        });
    }
};
