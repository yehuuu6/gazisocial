<?php

use App\Models\ZalimKasaba\Lobby;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Lobby::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->integer('place')->nullable();
            $table->boolean('is_online')->default(false);
            $table->boolean('is_host')->default(false);
            $table->boolean('can_haunt')->default(false);
            $table->boolean('self_healed')->default(false);
            $table->boolean('is_cleaned')->default(false);
            $table->boolean('is_alive')->default(true);
            $table->integer('death_night')->nullable();
            $table->text('last_will')->nullable();
            $table->integer('ability_uses')->nullable();
            $table->foreignId('game_role_id')->nullable()->constrained('game_roles')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
