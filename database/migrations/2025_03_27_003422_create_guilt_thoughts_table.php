<?php

use App\Models\ZalimKasaba\Lobby;
use App\Models\ZalimKasaba\Player;
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
        Schema::create('guilt_thoughts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Lobby::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Player::class)->constrained()->cascadeOnDelete();
            $table->integer('night');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guilt_thoughts');
    }
};
