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
        Schema::create('lobbies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('host_id')->constrained('users');
            $table->string('name');
            $table->integer('available_trials')->default(3);
            $table->timestamp('countdown_start')->nullable();
            $table->timestamp('countdown_end')->nullable();
            $table->integer('max_players')->default(6);
            $table->string('state')->default('lobby');
            $table->integer('day_count')->default(0);
            $table->boolean('is_listed')->default(true);
            $table->string('status')->default('waiting_host');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lobbies');
    }
};
