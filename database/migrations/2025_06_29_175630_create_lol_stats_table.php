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
        Schema::create('lol_stats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('champion_played');
            $table->text('champion_played_icon');
            $table->integer('kills');
            $table->integer('deaths');
            $table->integer('assists');
            $table->integer('cs');
            $table->foreignId('contest_id')->unique()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lol_stats');
    }
};
