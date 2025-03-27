<?php

use App\Models\ZalimKasaba\Lobby;
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
        Schema::create('witch_poisons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Lobby::class)->constrained()->cascadeOnDelete();
            $table->foreignId('target_id')->constrained('players')->cascadeOnDelete();
            $table->foreignId('poisoner_id')->constrained('players')->cascadeOnDelete();
            $table->integer('poisoned_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('witch_poisons');
    }
};
