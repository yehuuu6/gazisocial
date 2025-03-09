<?php

use App\Models\ZalimKasaba\Lobby;
use App\Models\ZalimKasaba\Player;
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
        Schema::create('final_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Lobby::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Player::class, 'voter_id')->constrained('players')->cascadeOnDelete();
            $table->foreignIdFor(Player::class, 'target_id')->constrained('players')->cascadeOnDelete();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_votes');
    }
};
